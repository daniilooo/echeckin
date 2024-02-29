<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Lateral Accordion com Bootstrap</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Menu lateral -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="#" data-toggle="collapse" data-target="#submenu1" aria-expanded="true" aria-controls="submenu1">
                Opção 1
              </a>
              <div id="submenu1" class="collapse">
                <ul class="nav flex-column pl-3">
                  <li class="nav-item">
                    <a class="nav-link" href="#">Subitem 1.1</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Subitem 1.2</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" data-toggle="collapse" data-target="#submenu2" aria-expanded="true" aria-controls="submenu2">
                Opção 2
              </a>
              <div id="submenu2" class="collapse">
                <ul class="nav flex-column pl-3">
                  <li class="nav-item">
                    <a class="nav-link" href="#">Subitem 2.1</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Subitem 2.2</a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Conteúdo da página -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <!-- Seu conteúdo aqui -->
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
