<div style="padding: 28px;">

    <!-- Page Header -->
    <div class="adm-page-header">
        <div class="adm-page-title">
            <div class="title-icon"><i class="fa fa-plus-circle"></i></div>
            <div>
                <h1>Novo Serviço</h1>
                <p>Preencha os dados para cadastrar um serviço</p>
            </div>
        </div>
        <a href="/backend/servico/listar" class="adm-btn adm-btn-edit">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- Form Card -->
    <div class="adm-form-page" style="max-width:760px;">
        <div class="adm-form-card">
            <div class="adm-form-card-header">
                <div class="header-icon"><i class="fa fa-briefcase"></i></div>
                <h2>Dados do Serviço</h2>
            </div>

            <form action="/backend/servico/salvar" method="POST" enctype="multipart/form-data">
                <div class="adm-form-card-body">

                    <div class="adm-form-group">
                        <label for="nome_servico">Nome do Serviço</label>
                        <input type="text" id="nome_servico" name="nome_servico"
                               placeholder="Ex: Alvenaria, Pintura, Elétrica..." required>
                    </div>

                    <div class="adm-form-group">
                        <label for="descricao_servico">Descrição Curta</label>
                        <input type="text" id="descricao_servico" name="descricao_servico"
                               placeholder="Breve descrição do serviço">
                    </div>

                    <div class="adm-form-group">
                        <label for="foto_servico">Foto Principal</label>
                        <input type="file" id="foto_servico" name="foto_servico"
                               accept="image/*" required>
                        <p class="hint">Formatos aceitos: JPG, PNG, WEBP. A imagem será comprimida automaticamente.</p>
                    </div>

                    <!-- Image Preview -->
                    <div class="adm-img-preview-grid">
                        <div class="adm-img-preview-box">
                            <h4><i class="fa fa-image"></i> Original</h4>
                            <img id="previewOriginal" alt="Preview original">
                            <p id="infoOriginal"></p>
                        </div>
                        <div class="adm-img-preview-box">
                            <h4><i class="fa fa-compress"></i> Comprimida (WebP)</h4>
                            <img id="previewCompressed" alt="Preview comprimido">
                            <p id="infoCompressed"></p>
                        </div>
                    </div>

                </div>
                <div class="adm-form-card-footer">
                    <button type="submit" class="adm-btn adm-btn-primary">
                        <i class="fa fa-save"></i> Salvar Serviço
                    </button>
                    <a href="/backend/servico/listar" class="adm-btn adm-btn-edit">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById('foto_servico');
  const outputDiv = document.getElementById('infoCompressed');
  const previewImg = document.getElementById('previewCompressed');
  const previewOriginal = document.getElementById('previewOriginal');
  const infoOriginal = document.getElementById('infoOriginal');

  if (!input || !outputDiv || !previewImg || !previewOriginal || !infoOriginal) {
      console.error("Elementos do formulário não encontrados para o preview de imagem.");
      return;
  }

  input.addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    if (file.type === 'image/webp' && file.name.endsWith('.webp')) return;

    previewOriginal.style.display = 'block';
    previewOriginal.src = URL.createObjectURL(file);
    infoOriginal.innerText = "Processando...";

    try {
      const result = await compressImage(file);

      infoOriginal.innerHTML = `
          Tamanho: ${(result.meta.originalSize / 1024).toFixed(2)} KB<br>
          Dimensões: ${result.meta.originalWidth} × ${result.meta.originalHeight} px
      `;

      previewImg.style.display = 'block';
      previewImg.src = URL.createObjectURL(result.file);

      const colorBox = `<span style="display:inline-block;width:14px;height:14px;background:${result.meta.dominantColor};border-radius:3px;border:1px solid #ccc;vertical-align:middle;margin-left:4px;"></span>`;

      outputDiv.innerHTML = `
        Tamanho final: ${(result.meta.compressedSize / 1024).toFixed(2)} KB<br>
        Dimensões: ${result.meta.finalWidth} × ${result.meta.finalHeight} px<br>
        Cor predominante: ${result.meta.dominantColor} ${colorBox}<br>
        <span class="ready"><i class="fa fa-check-circle"></i> Pronto para envio!</span>
      `;

      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(result.file);
      input.files = dataTransfer.files;

    } catch (err) {
      console.error(err);
      infoOriginal.innerText = "Erro ao processar.";
      alert("Erro ao processar imagem para compressão.");
    }
  });
});

function getAverageColor(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    let r = 0, g = 0, b = 0, count = 0;
    for (let i = 0; i < data.length; i += 40) {
        r += data[i]; g += data[i + 1]; b += data[i + 2]; count++;
    }
    r = Math.floor(r / count); g = Math.floor(g / count); b = Math.floor(b / count);
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
}

async function compressImage(file, quality = 0.8, maxWidth = 1200) {
  return new Promise((resolve, reject) => {
    if (!file.type.match(/image.*/)) { reject(new Error("O arquivo não é uma imagem.")); return; }
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = (event) => {
      const img = new Image();
      img.src = event.target.result;
      img.onload = () => {
        const originalWidth = img.naturalWidth;
        const originalHeight = img.naturalHeight;
        let width = originalWidth, height = originalHeight;
        if (width > maxWidth) { height = Math.round((height * maxWidth) / width); width = maxWidth; }
        const canvas = document.createElement('canvas');
        canvas.width = width; canvas.height = height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, width, height);
        const dominantColor = getAverageColor(ctx, width, height);
        canvas.toBlob((blob) => {
          if (!blob) { reject(new Error("Erro ao processar.")); return; }
          const newName = file.name.replace(/\.[^/.]+$/, "") + ".webp";
          const newFile = new File([blob], newName, { type: "image/webp", lastModified: Date.now() });
          resolve({ file: newFile, meta: { originalSize: file.size, compressedSize: newFile.size, originalWidth, originalHeight, finalWidth: width, finalHeight: height, dominantColor } });
        }, 'image/webp', quality);
      };
      img.onerror = (err) => reject(err);
    };
    reader.onerror = (err) => reject(err);
  });
}
</script>