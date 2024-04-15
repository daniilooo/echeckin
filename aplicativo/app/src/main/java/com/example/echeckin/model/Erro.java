package com.example.echeckin.model;

import java.time.LocalDateTime;

public class Erro {
    private int idErro;
    private String localErro;
    private String erro;
    private int fkUsuario;
    private LocalDateTime dataHora;

    public void Erro(int idErro, String localErro, String erro, int fkUsuario, LocalDateTime dataHora){
        this.setIdErro(idErro);
        this.setLocalErro(localErro);
        this.setErro(erro);
        this.setFkUsuario(fkUsuario);
        this.setDataHora(dataHora);
    }

    public void setIdErro(int idErro){
        this.idErro = idErro;
    }

    public void setLocalErro(String localErro){
        this.localErro = localErro;
    }

    public void setErro(String erro){
        this.erro = erro;
    }

    public void setFkUsuario(int fkUsuario){
        this.fkUsuario = fkUsuario;
    }

    public void setDataHora(LocalDateTime dataHora){
        this.dataHora = dataHora;
    }

    public int getIdErro(){
        return this.idErro;
    }

    public String getLocalErro(){
        return this.localErro;
    }

    public String getErro(){
        return this.erro;
    }

    public int getFkUsuario(){
        return this.fkUsuario;
    }
}
