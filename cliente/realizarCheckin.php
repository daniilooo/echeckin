
<!DOCTYPE html><html lang="ja"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width">
<title>jsQR Demo</title>
<link href="https://fonts.googleapis.com/css?family=Ropa+Sans" rel="stylesheet">
<style>
body {
  font-family: 'Ropa Sans', sans-serif;
  color: #333;
  max-width: 640px;
  margin: 0 auto;
  position: relative;
}

#githubLink {
  position: absolute;
  right: 0;
  top: 12px;
  color: #2D99FF;
}

h1 {
  margin: 10px 0;
  font-size: 40px;
}

#loadingMessage {
  text-align: center;
  padding: 40px;
  background-color: #eee;
}

#canvas {
  width: 100%;
}

#outputContainer {
  margin-top: 20px;
  background: #eee;
  padding: 10px;
  padding-bottom: 0;
  word-break: break-all;
}

#outputContainer div {
  padding-bottom: 10px;
  word-wrap: break-word;
}

#noQRFound {
  text-align: center;
}
</style>
</head>
<body>
<h1>jsQR Demo</h1>
<a id="githubLink" href="https://github.com/code4fukui/jsQR">View documentation on Github</a>
<p>Pure JavaScript QR code decoding library.</p>
<div id="loadingMessage">🎥 Unable to access video stream (please make sure you have a webcam enabled)</div>
<canvas id="canvas"></canvas>
<div id="outputContainer">
  <div id="outputMessage">No QR code detected.</div>
  <div><b>Data:</b> <span id="outputData"></span></div>
  <div><b>Data(bin as hex):</b> <span id="outputDataBin"></span></div>
</div>

<script type="module">
//import { jsQR } from "https://github.com/cozmo/jsQR.js";
import { jsQR } from "./jsQR.js";
import { hex } from "https://code4sabae.github.io/js/hex.js";

onload = async () => {
  const video = document.createElement("video");
  const g = canvas.getContext("2d");

  const drawLine = (begin, end, color) => {
    g.beginPath();
    g.moveTo(begin.x, begin.y);
    g.lineTo(end.x, end.y);
    g.lineWidth = 4;
    g.strokeStyle = color;
    g.stroke();
  }

  // Use facingMode: environment to attemt to get the front camera on phones
  const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
  video.srcObject = stream;
  video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
  video.play();

  const tick = () => {
    loadingMessage.innerText = "⌛ Loading video..."
    if (video.readyState === video.HAVE_ENOUGH_DATA) {
      loadingMessage.hidden = true;
      canvas.hidden = false;
      outputContainer.hidden = false;

      canvas.height = video.videoHeight;
      canvas.width = video.videoWidth;
      g.drawImage(video, 0, 0, canvas.width, canvas.height);
      const imageData = g.getImageData(0, 0, canvas.width, canvas.height);
      const code = jsQR(imageData.data, imageData.width, imageData.height, {
        inversionAttempts: "dontInvert",
      });
      if (code) {
        const color = "#FF3B58";
        drawLine(code.location.topLeftCorner, code.location.topRightCorner, color);
        drawLine(code.location.topRightCorner, code.location.bottomRightCorner, color);
        drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, color);
        drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, color);
        outputMessage.hidden = true;
        outputData.parentElement.hidden = false;
        outputData.innerText = code.data;
        outputDataBin.innerText = hex.fromBin(code.binaryData);
      } else {
        //outputMessage.hidden = false;
        //outputData.parentElement.hidden = true;
      }
    }
    requestAnimationFrame(tick);
  };
  tick();
};
</script>

</body>
</html>
