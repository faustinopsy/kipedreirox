<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Erro Interno</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; color: #333; }
        .container { text-align: center; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 500px; width: 90%; border-top: 5px solid #DC3545; }
        h1 { font-size: 80px; margin: 0; color: #DC3545; }
        h2 { margin-top: 10px; font-size: 24px; color: #2a2a2a; }
        p { color: #666; margin-bottom: 30px; }
        .error-details { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; font-size: 0.9rem; margin-bottom: 20px; text-align: left; overflow-x: auto; font-family: monospace; }
        a { display: inline-block; padding: 10px 20px; background-color: #2a2a2a; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background 0.3s; }
        a:hover { background-color: #444; }
    </style>
</head>
<body>
    <div class="container">
        <h1>500</h1>
        <h2>Erro Interno do Servidor</h2>
        <p>Algo deu errado do nosso lado. Tente novamente mais tarde.</p>
        
        <?php if (isset($errorMessage) && !empty($errorMessage)): ?>
            <div class="error-details">
                <strong>Detalhes:</strong> <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <a href="/">Voltar ao Início</a>
    </div>
</body>
</html>
