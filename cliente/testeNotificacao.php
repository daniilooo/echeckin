<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações Web</title>
</head>
<body>

<button onclick="mostrarNotificacao()">Mostrar Notificação</button>

<script>
function mostrarNotificacao() {
    if ('Notification' in window) {
        
        if (Notification.permission === 'granted') {
            
            var notification = new Notification('Você deve fazer checkin agora', {
                body: 'Você tem 5 minutos para fazer o checkin na ilha. Dirija-se ao QrCode para fazer checkin.',
                icon: '../img/notif_guiborLog.png' 
            });

            
            notification.addEventListener('click', function() {                
                window.location.href = "realizarCheckin.php"
            });
        } else if (Notification.permission !== 'denied') {
            
            Notification.requestPermission().then(function (permission) {
                if (permission === 'granted') {
                    mostrarNotificacao();
                }
            });
        }
    }
}
</script>

</body>
</html>