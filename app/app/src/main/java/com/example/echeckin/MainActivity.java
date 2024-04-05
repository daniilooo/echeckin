package com.example.echeckin;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.SurfaceTexture;
import android.os.Bundle;
import android.os.Environment;
import android.view.TextureView;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStream;
import java.sql.Time;
import java.util.Base64;

public class MainActivity extends AppCompatActivity {
    private WebView webView;
    private String caminhoDaImagem;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        webView = findViewById(R.id.webview);

        // Habilitar JavaScript
        WebSettings webSettings = webView.getSettings();
        webSettings.setJavaScriptEnabled(true);

        // Permitir que a WebView abra janelas
        webSettings.setJavaScriptCanOpenWindowsAutomatically(true);

        // Configurar o WebViewClient para carregar URLs na própria WebView
        webView.setWebViewClient(new WebViewClient());

        // Configurar o WebChromeClient para exibir o progresso da página
        webView.setWebChromeClient(new WebChromeClient());

        // Carregar a página da web
        webView.loadUrl("https://sysdesk.com.br/echeckin/cliente/");

        // Adicionar a interface JavaScript para comunicação com o código Java
        webView.addJavascriptInterface(new WebAppInterface(this), "android");
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        IntentResult result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        captureScreenAndSave();

        try {
            Thread.sleep(3000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }

        if (result != null) {

            if (result.getContents() != null) {
                // URL lida do QR code
                String qrCodeUrl = result.getContents();

                String imagem = convertToBase64(caminhoDaImagem);
                //String teste = qrCodeUrl+"&imagem="+imagem;

                webView.loadUrl(qrCodeUrl);
            } else {
                Toast.makeText(this, "Erro ao ler o QR code.", Toast.LENGTH_SHORT).show();
            }
        } else {
            super.onActivityResult(requestCode, resultCode, data);
        }
    }

    public static String convertToBase64(String imagePath) {
        try {
            File file = new File(imagePath);
            FileInputStream fis = new FileInputStream(file);
            ByteArrayOutputStream bos = new ByteArrayOutputStream();
            byte[] buf = new byte[1024];
            for (int readNum; (readNum = fis.read(buf)) != -1;) {
                bos.write(buf, 0, readNum);
            }
            byte[] bytes = bos.toByteArray();
            fis.close();
            bos.close();
            return Base64.getEncoder().encodeToString(bytes);
        } catch (IOException ex) {
            ex.printStackTrace();
            return null; // Ou lance uma exceção personalizada ou retorne um valor padrão, dependendo do seu caso de uso
        }
    }


    private void captureScreenAndSave() {
        // Capturar a tela como um Bitmap
        webView.measure(View.MeasureSpec.makeMeasureSpec(
                        webView.getWidth(), View.MeasureSpec.EXACTLY),
                View.MeasureSpec.makeMeasureSpec(0, View.MeasureSpec.UNSPECIFIED));
        webView.layout(0, 0, webView.getMeasuredWidth(), webView.getMeasuredHeight());
        webView.setDrawingCacheEnabled(true);
        webView.buildDrawingCache(true);
        Bitmap screenshot = Bitmap.createBitmap(webView.getDrawingCache());
        webView.setDrawingCacheEnabled(false);

        // Salvar o Bitmap como uma imagem
        try {
            File directory = new File(Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_PICTURES), "eCheckin");
            if (!directory.exists()) {
                directory.mkdirs();
            }

            String fileName = "screenshot_" + System.currentTimeMillis() + ".png";
            File file = new File(directory, fileName);

            caminhoDaImagem = directory+"/"+fileName;

            FileOutputStream fos = new FileOutputStream(file);
            screenshot.compress(Bitmap.CompressFormat.PNG, 100, fos);
            fos.flush();
            fos.close();

            Toast.makeText(this, "Captura de tela salva com sucesso.", Toast.LENGTH_SHORT).show();
        } catch (IOException e) {
            e.printStackTrace();
            Toast.makeText(this, "Erro ao salvar a captura de tela.", Toast.LENGTH_SHORT).show();
        }
    }




    public void startQRCodeScanner() {
        IntentIntegrator integrator = new IntentIntegrator(this);
        integrator.setDesiredBarcodeFormats("QR_CODE");
        integrator.setPrompt("Aponte para o QR code");
        integrator.setOrientationLocked(true);
        integrator.setTorchEnabled(true);
        integrator.initiateScan();
    }
}
