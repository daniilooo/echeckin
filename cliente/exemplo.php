<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Geolocalização</title>
<script>
document.addEventListener("DOMContentLoaded", function() {
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;
      
      // Exibir as informações de geolocalização na tela
      document.getElementById("latitude").textContent = "Latitude: " + latitude;
      document.getElementById("longitude").textContent = "Longitude: " + longitude;
    });
  } else {
    // Caso o navegador não suporte geolocalização
    document.getElementById("info").textContent = "Geolocalização não é suportada pelo seu navegador.";
  }
});
</script>
</head>
<body>
<div id="info">
  <p>Obtendo informações de geolocalização...</p>
</div>
<div id="latitude"></div>
<div id="longitude"></div>
</body>
</html>
