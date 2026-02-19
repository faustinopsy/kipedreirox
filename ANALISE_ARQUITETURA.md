# Análise de Arquitetura e Sugestões de Melhoria

Este documento apresenta uma análise técnica detalhada do projeto **Ki-Pedreiro**, identificando falhas de arquitetura, riscos de segurança e erros lógicos, seguidos de sugestões de correção.

## 🚨 1. Problemas Críticos Identificados

### 1.1. Arquitetura Desarticulada (Híbrida e Confusa)
*   **Problema**: Existe uma duplicação de responsabilidades. O projeto possui um frontend estático (`index.html`) e um sistema MVC completo no backend (`/backend`), mas eles não se conversam corretamente.
*   **Evidência**: O `contato.html` aponta para um arquivo solto `enviaemail.php`, ignorando completamente a estrutura de rotas e controllers do backend (`ServicoController`, etc.).
*   **Risco**: Dificuldade de manutenção. Alterar a lógica de negócios no backend não reflete no frontend público se este continuar usando scripts isolados.

### 1.2. Segurança: Credenciais Hardcoded
*   **Problema**: O arquivo `backend/Database/Config.php` contém credenciais de banco de dados diretamente no código ("hardcoded").
*   **Evidência**:
    ```php
    'username' => 'root',
    'password' => NULL,
    ```
*   **Risco**: Vazamento de credenciais se o código for compartilhado ou exposto. Em produção, isso é uma falha grave de segurança.

### 1.3. Rotas Quebradas / Arquivos Faltantes
*   **Problema**: O formulário de contato (`contato.html`) envia POST para `enviaemail.php`, mas este arquivo **não existe** na estrutura listada do projeto.
*   **Evidência**: `action="enviaemail.php"` no HTML, mas arquivo ausente na raiz e no backend.
*   **Consequência**: O formulário de contato não funciona (Retornará erro 404).

### 1.4. Segurança da API (Comentada)
*   **Problema**: O backend possui lógica de verificação de chave de API (`API_KEY`) no `backend/index.php`, mas está **comentada**.
*   **Risco**: Qualquer rota exposta em `Rotas.php` (como `/api/usuarios` ou `/api/servicos`) pode estar acessível publicamente sem autenticação, expondo dados sensíveis.

## 💡 2. Sugestões de Melhoria e Plano de Correção

### 2.1. Unificação da Arquitetura
**Recomendação**: Centralizar o fluxo no Backend ou transformar o Frontend em cliente da API.
*   **Abordagem A (SPA/API)**: Manter o HTML estático, mas alterar os formulários e carregamento de dados para usar `fetch()` chamando as rotas da API (`/backend/api/...`).
*   **Abordagem B (Full MVC)**: Mover os arquivos HTML estáticos para dentro de `backend/Views` e servi-los através de Controllers, garantindo que todas as requisições passem pelo roteador.

### 2.2. Correção Immediata do Formulário de Contato
**Onde corrigir**: `contato.html` e Backend.
1.  **Backend**: Criar uma rota (ex: `POST /api/contato`) em `backend/Rotas/Rotas.php` que aponte para um `ContatoController`.
2.  **Frontend**: Alterar o `action` do formulário ou usar JavaScript para submeter os dados para essa nova rota.

### 2.3. Segurança e Configuração (Environment)
1.  **Variáveis de Ambiente**: Implementar o uso de um arquivo `.env` (usando bibliotecas como `vlucas/phpdotenv`) para armazenar credenciais de banco.
2.  **Config.php**: Alterar para ler de `getenv()` ou similar.
    ```php
    'password' => getenv('DB_PASSWORD'),
    ```

### 2.4. Organização de Arquivos
*   Remover scripts soltos que não passam pelo `index.php` do backend.
*   Garantir que todo o acesso ao banco de dados seja feito exclusivamente através dos Models/Services, nunca diretamente em arquivos de view ou scripts soltos.

## 📝 Resumo de Ações Recomendadas

| Prioridade | Ação | Arquivos Envolvidos |
| :--- | :--- | :--- |
| 🔴 **Alta** | Criar Controller para Contato e corrigir action do form | `contato.html`, `Rotas.php`, `ContatoController.php` |
| 🔴 **Alta** | Remover credenciais do código (usar .env) | `Config.php`, `.env` |
| 🟡 **Média** | Ativar/Implementar Autenticação nas rotas de API | `backend/index.php`, `Middleware` |
| 🟢 **Baixa** | Migrar HTML estático para Views do MVC | `index.html` -> `Views/home.php` |

---
*Este documento foi gerado automaticamente por análise de código via Agente AI.*
