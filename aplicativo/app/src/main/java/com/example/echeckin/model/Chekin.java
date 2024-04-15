package com.example.echeckin.model;

import java.time.LocalDateTime;
import java.util.Date;

public class Chekin {

    private int idCheckin;
    private int idUsuario;
    private LocalDateTime dataHora;

    public void Checkin(int idCheckin, int idUsuario, LocalDateTime dataHora){
        this.setIdCheckin(idCheckin);
        this.setIdUsuario(idUsuario);
        this.setDataHora(dataHora);
    }

    public void setIdCheckin(int idCheckin){
        this.idCheckin = idCheckin;
    }

    public void setIdUsuario(int idUsuario){
        this.idUsuario = idUsuario;
    }

    public void setDataHora(LocalDateTime dataHora){
        this.dataHora = dataHora;
    }

    public int getIdCheckin(){
        return this.idCheckin;
    }

    public int getIdUsuario() {
        return this.idUsuario;
    }

    public LocalDateTime getDataHora(){
        return this.dataHora;
    }

}
