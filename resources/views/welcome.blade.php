<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env("APP_NAME") }} - Botman Chatbot</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
    </body>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">
    <style>
        .chat {
            background-color: white !important;
        }
    </style>
    <script>
        var botmanWidget = {
            aboutText: 'Sistema de Consultas',
            introMessage: "Bienvenido al sistema interactivo de consultas, Pregunta para iniciar conversación",
            title:'Charlie Bot',
            mainColor:'#c02026',
            bubbleBackground:'#c02026',
            headerTextColor: '#fff',
        };
    </script>

    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

</html>
