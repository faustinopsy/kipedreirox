<div class="w3-container">
    <h3>Novo Serviço</h3>
    <form action="/backend/servico/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
        
        <p>
        <label class="w3-text-blue"><b>Nome do Serviço</b></label>
        <input class="w3-input w3-border" name="nome_servico" type="text" required>
        </p>
        
        <p>
        <label class="w3-text-blue"><b>Descrição Curta</b></label>
        <input class="w3-input w3-border" name="descricao_servico" type="text">
        </p>

        <p>
        <label class="w3-text-blue"><b>Foto Principal</b></label>
        <input class="w3-input w3-border" id="foto_servico" name="foto_servico" type="file" required>
        </p>
        <div style="margin-top: 20px; display: flex; gap: 20px;">
      <div>
        <h3>Original</h3>
        <img id="previewOriginal" style="max-width: 300px;" />
        <p id="infoOriginal"></p>
      </div>
      <div>
        <h3>Comprimida (WebP)</h3>
        <img id="previewCompressed" style="max-width: 300px;" />
        <p id="infoCompressed"></p>
      </div>
    </div>
        <p>
        <button class="w3-button w3-blue">Salvar Serviço</button>
        </p>

    </form>
</div>
<script>

document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById('foto_servico');
  const outputDiv = document.getElementById('infoCompressed');
  const previewImg = document.getElementById('previewCompressed');
  const previewOriginal = document.getElementById('previewOriginal');
  const infoOriginal = document.getElementById('infoOriginal');

  // Verifica se todos os elementos existem para evitar erros silenciosos
  if (!input || !outputDiv || !previewImg || !previewOriginal || !infoOriginal) {
      console.error("Elementos do formulário não encontrados para o preview de imagem.");
      return;
  }

  input.addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    // Evita loop se for o arquivo já comprimido
    if (file.type === 'image/webp' && file.name.endsWith('.webp')) {
        return;
    }

    // --- PREVIEW IMEDIATO DO ORIGINAL ---
    // Garante que a img esteja visível caso estivesse oculta
    previewOriginal.style.display = 'block'; 
    previewOriginal.src = URL.createObjectURL(file);
    infoOriginal.innerText = "Carregando compressão...";

    try {
      const result = await compressImage(file);
      
      // Atualiza info do original
      infoOriginal.innerHTML = `
          Tamanho: ${(result.meta.originalSize / 1024).toFixed(2)} KB<br>
          Dimensões: ${result.meta.originalWidth} x ${result.meta.originalHeight} px
      `;

      // Mostra o resultado processado
      previewImg.style.display = 'block';
      previewImg.src = URL.createObjectURL(result.file);
      
      const colorBox = `<div style="
          display:inline-block; 
          width:20px; 
          height:20px; 
          background-color:${result.meta.dominantColor}; 
          border:1px solid #ccc;
          vertical-align: middle;
          margin-left: 5px;"></div>`;

      outputDiv.innerHTML = `
        <strong>Metadados Extraídos:</strong><br>
        Tamanho Final: ${(result.meta.compressedSize / 1024).toFixed(2)} KB<br>
        Dimensões Finais: ${result.meta.finalWidth} x ${result.meta.finalHeight} px<br>
        Cor Predominante: ${result.meta.dominantColor} ${colorBox}<br>
        <hr>
        <span style="color: green">Pronto para envio!</span>
      `;

      // Substituição do input
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(result.file);
      input.files = dataTransfer.files;

      console.log("Imagem comprimida definida no input.");
         
    } catch (err) {
      console.error(err);
      infoOriginal.innerText = "Erro ao processar.";
      alert("Erro ao processar imagem para compressão.");
    }
  });
});

function getAverageColor(ctx, width, height) {
    // Pega os dados dos pixels (R, G, B, Alpha)
    // Para performance, poderíamos ler apenas uma amostra, mas aqui leremos tudo
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    let r = 0, g = 0, b = 0;
    let count = 0;

    // Loop pulando de 10 em 10 pixels para ser MUITO rápido
    // i += 4 * 10 (4 canais: r,g,b,a)
    for (let i = 0; i < data.length; i += 40) {
        r += data[i];
        g += data[i + 1];
        b += data[i + 2];
        count++;
    }

    // Calcula a média
    r = Math.floor(r / count);
    g = Math.floor(g / count);
    b = Math.floor(b / count);

    // Converte para Hexadecimal (#RRGGBB)
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
}

async function compressImage(file, quality = 0.8, maxWidth = 1200) {
  return new Promise((resolve, reject) => {
    if (!file.type.match(/image.*/)) {
      reject(new Error("O arquivo não é uma imagem."));
      return;
    }

    const reader = new FileReader();
    reader.readAsDataURL(file);

    reader.onload = (event) => {
      const img = new Image();
      img.src = event.target.result;

      img.onload = () => {
        // --- Captura dados originais ---
        const originalWidth = img.naturalWidth;
        const originalHeight = img.naturalHeight;

        // --- Lógica de Redimensionamento ---
        let width = originalWidth;
        let height = originalHeight;

        if (width > maxWidth) {
          height = Math.round((height * maxWidth) / width);
          width = maxWidth;
        }

        const canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        
        const ctx = canvas.getContext('2d');
        // Desenha a imagem redimensionada no canvas
        ctx.drawImage(img, 0, 0, width, height);

        // --- Extração de Cor ---
        // Analisa os pixels da imagem já desenhada
        const dominantColor = getAverageColor(ctx, width, height);

        canvas.toBlob(
          (blob) => {
            if (!blob) {
              reject(new Error("Erro ao processar.")); 
              return;
            }

            const newName = file.name.replace(/\.[^/.]+$/, "") + ".webp";
            const newFile = new File([blob], newName, {
              type: "image/webp",
              lastModified: Date.now(),
            });
            
            // Retorna um objeto rico com todos os metadados
            resolve({
              file: newFile,
              meta: {
                originalSize: file.size,
                compressedSize: newFile.size,
                originalWidth: originalWidth,
                originalHeight: originalHeight,
                finalWidth: width,
                finalHeight: height,
                dominantColor: dominantColor // Ex: #ff0000
              }
            });
          },
          'image/webp',
          quality
        );
      };
      img.onerror = (err) => reject(err);
    };
    reader.onerror = (err) => reject(err);
  });
}
</script>