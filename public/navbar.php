<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand mr-auto" href="#">eCheckin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Gerenciar<br>usuários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Gerenciar<br>empresas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Gerenciar<br>Locais cadastrados</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Relatórios<br>disponíveis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Manual do<br>sistema</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link user-box" style="background-color: #B0C4DE;">
                    <?php echo $usuario->getNome() ?><br>Gerenciar conta
                </a>
            </li>
        </ul>
    </div>
</nav>
