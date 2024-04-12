package com.example.echeckin;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;

import androidx.appcompat.app.AppCompatActivity;

public class SplashActivity extends AppCompatActivity {

    private static final int SPLASH_TIME_OUT = 5000; // Tempo de exibição da tela de splash em milissegundos

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.splash_activity);

        // Após o tempo definido, iniciar a atividade principal e encerrar a tela de splash
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                // Iniciar a atividade principal
                Intent intent = new Intent(SplashActivity.this, LoginActivity.class);
                startActivity(intent);

                // Fechar a atividade de splash
                finish();
            }
        }, SPLASH_TIME_OUT);
    }


}

