# Sistema de Ronda e Checkin

## Tecnologias Utilizadas
- **Frontend:**
  - **Bootstrap:** Utilizado para a criação da interface do aplicativo, proporcionando um design responsivo e agradável.
  - **JavaScript:** Implementação de funcionalidades interativas no frontend, como a geração dinâmica de placas de checkpoint e interação com o QR code.
  
- **Backend:**
  - **PHP (Orientado a Objetos):** Utilizado para a lógica de negócios e interação com o banco de dados.
  - **MySQL:** Banco de dados relacional para armazenamento de informações sobre empresas, locais e usuários.
  
- **Mobile (Android):**
  - **Java:** Desenvolvimento do cliente Android para leitura de QR codes e interação com o servidor PHP.

## Arquitetura Utilizada
- **MVC (Model-View-Controller):**
  - **Model:** Responsável pela manipulação dos dados, incluindo interações com o banco de dados MySQL. As classes de modelo representam empresas, locais e usuários.
  - **View:** Focado na apresentação e interação do usuário, incluindo o uso do Bootstrap para o layout responsivo e amigável.
  - **Controller:** Responsável por receber e processar as requisições do frontend, gerenciando a lógica de negócios e interagindo com as classes de modelo.

## Funcionamento do App
1. **Cadastro de Empresas:**
   - O administrador cadastra empresas no sistema, fornecendo informações básicas.

2. **Cadastro de Locais:**
   - Para cada empresa, são cadastrados os locais estratégicos onde as rondas serão realizadas.
   - Ao cadastrar um local, o sistema automaticamente gera placas de checkpoint com QR codes únicos que apontam para URLs específicas.

3. **Cadastro de Usuários:**
   - Os usuários são cadastrados, associados às empresas e recebem credenciais de acesso.

4. **Checkin com QR Code:**
   - Os funcionários, utilizando o cliente Android, realizam checkin nos locais escaneando o QR code gerado pelo sistema.
   - O cliente Android interage com o servidor PHP para registrar o checkin no banco de dados.

5. **Relatórios e Monitoramento:**
   - O sistema fornece relatórios de rondas, checkins e atividades associadas, permitindo monitoramento eficiente.
   - Administradores podem acessar informações detalhadas sobre as atividades de segurança realizadas nos locais.

## Como Contribuir
1. Clone o repositório.
2. Instale as dependências necessárias.
3. Configure o banco de dados MySQL de acordo com o esquema fornecido.
4. Contribua para melhorias e correções.
5. Abra pull requests para revisão.

## Autor
Danilo Franco

