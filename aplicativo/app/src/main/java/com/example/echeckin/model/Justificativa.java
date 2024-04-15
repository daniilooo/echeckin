package com.example.echeckin.model;

import java.time.LocalDateTime;

public class Justificativa {

    private int idJustificativa;
    private int fkLocal;
    private int fkUsuario;
    private LocalDateTime dataHora;
    private String justificativa;

    public void Justificativa(int idJustificativa, int fkLocal, int fkUsuario, LocalDateTime dataHora, String justificativa){
        this.setIdJustificativa(idJustificativa);
        this.setFkLocal(fkLocal);
        this.setFkUsuario(fkUsuario);
        this.setDataHora(dataHora);
        this.setJustificativa(justificativa);
    }

    public void setIdJustificativa(int idJustificativa){
        this.idJustificativa = idJustificativa;
    }

    public void setFkLocal(int idLocal){
        this.fkLocal = fkLocal;
    }

    public void setFkUsuario(int fkUsuario){
        this.fkUsuario = fkUsuario;
    }

    public void setDataHora(LocalDateTime dataHora){
        this.dataHora = dataHora;
    }

    public void setJustificativa(String justificativa){
        this.justificativa = justificativa;
    }

    public int getIdJustificativa(){
        return this.idJustificativa;
    }

    public int getFkLocal(){
        return this.fkLocal;
    }

    public int getFkUsuario(){
        return this.fkUsuario;
    }

    public LocalDateTime getDataHora(){
        return this.dataHora;
    }

    public String getJustificativa(){
        return this.justificativa;
    }

}
