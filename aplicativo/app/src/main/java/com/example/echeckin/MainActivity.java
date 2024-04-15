package com.example.echeckin;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class MainActivity extends AppCompatActivity {

    Button btnCheckin;
    Button btnJustificativa;
    Button btnGerenciarAcesso;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        onCreate();
        btnCheckin_OnClick();
        btnJustificativa_OnClick();
        btnGerenciarAcesso_OnClick();

    }

    private void onCreate(){
        btnCheckin = findViewById(R.id.btnCheckin);
        btnJustificativa = findViewById(R.id.btnJustificativa);
        btnGerenciarAcesso = findViewById(R.id.btnGerAcesso);
    }

    private void btnCheckin_OnClick(){
        btnCheckin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //instanciar o leitor de qrcodeAqui
            }
        });
    }

    private void btnJustificativa_OnClick(){
        btnJustificativa.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), JustificativaActivity.class);
                startActivity(intent);
            }
        });
    }

    private void btnGerenciarAcesso_OnClick(){
        btnGerenciarAcesso.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), GerenciarAcessoActivity.class);
                startActivity(intent);
            }
        });
    }




}
