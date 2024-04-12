package com.example.echeckin;

import android.content.Intent;
import android.webkit.JavascriptInterface;
import android.widget.Toast;

import com.google.zxing.integration.android.IntentIntegrator;

public class WebAppInterface {
    private MainActivity activity;

    public WebAppInterface(MainActivity activity) {
        this.activity = activity;
    }

    @JavascriptInterface
    public void openQRCodeScanner() {
        activity.runOnUiThread(new Runnable() {
            @Override
            public void run() {
                // Inicie o leitor de QR code
                activity.startQRCodeScanner();
            }
        });
    }
}