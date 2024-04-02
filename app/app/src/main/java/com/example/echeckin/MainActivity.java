package com.example.echeckin;

import android.content.Intent;
import android.os.Bundle;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

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

                // Carregar a URL na WebView
                webView.loadUrl(qrCodeUrl);
            } else {
                Toast.makeText(this, "Erro ao ler o QR code.", Toast.LENGTH_SHORT).show();
            }
        } else {
            super.onActivityResult(requestCode, resultCode, data);
        }
    }



    public void startQRCodeScanner() {
        IntentIntegrator integrator = new IntentIntegrator(this);
        integrator.setPrompt("Aponte para o QR code");
        integrator.setOrientationLocked(true);

        integrator.setTorchEnabled(true);
        integrator.initiateScan();
    }
}
