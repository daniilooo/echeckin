package com.example.echeckin;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.os.Environment;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import java.io.File;
import java.io.FileOutputStream;
import java.io.OutputStream;
import java.sql.Time;

public class MainActivity extends AppCompatActivity {
    private WebView webView;

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

        if (result != null) {
            if (result.getContents() != null) {
                // URL lida do QR code
                String qrCodeUrl = result.getContents();

                // Obtém o caminho da imagem do QR code
                String qrCodeImagePath = result.getBarcodeImagePath();

                // Converte o caminho da imagem em um Bitmap
                Bitmap qrCodeBitmap = BitmapFactory.decodeFile(qrCodeImagePath);

                // Salva a foto do QR code na galeria
                saveQRCodeImageToGallery(this, qrCodeBitmap);

                // Carregar a URL na WebView
                webView.loadUrl(qrCodeUrl);
            } else {
                Toast.makeText(this, "Erro ao ler o QR code.", Toast.LENGTH_SHORT).show();
            }
        } else {
            super.onActivityResult(requestCode, resultCode, data);
        }
    }



    private void saveQRCodeImageToGallery(Context context, Bitmap qrCodeBitmap) {
        // Verificar se o Bitmap é nulo
        if (qrCodeBitmap == null) {
            Toast.makeText(context, "O Bitmap do QR code é nulo.", Toast.LENGTH_SHORT).show();
            return;
        }

        // Verificar se o armazenamento externo está disponível para escrita
        if (!isExternalStorageWritable()) {
            Toast.makeText(context, "O armazenamento externo não está disponível para escrita.", Toast.LENGTH_SHORT).show();
            return;
        }

        // Criar a pasta "eCheckin" dentro da pasta "Pictures"
        File directory = new File(Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_PICTURES), "eCheckin");
        if (!directory.exists()) {
            if (!directory.mkdirs()) {
                Toast.makeText(context, "Falha ao criar a pasta 'eCheckin'.", Toast.LENGTH_SHORT).show();
                return;
            }
        }

        // Criar o nome do arquivo
        String fileName = "QRCode_" + System.currentTimeMillis() + ".jpg";

        // Criar o arquivo de destino
        File destFile = new File(directory, fileName);

        try {
            // Salvar o Bitmap no arquivo de destino
            OutputStream outputStream = new FileOutputStream(destFile);
            qrCodeBitmap.compress(Bitmap.CompressFormat.JPEG, 100, outputStream);
            outputStream.flush();
            outputStream.close();

            Toast.makeText(context, "Foto do QR code salva com sucesso na galeria.", Toast.LENGTH_SHORT).show();
        } catch (Exception e) {
            e.printStackTrace();
            Toast.makeText(context, "Erro ao salvar a foto do QR code na galeria.", Toast.LENGTH_SHORT).show();
        }
    }

    private boolean isExternalStorageWritable() {
        String state = Environment.getExternalStorageState();
        return Environment.MEDIA_MOUNTED.equals(state);
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
