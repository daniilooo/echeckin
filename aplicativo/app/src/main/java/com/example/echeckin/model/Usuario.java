package com.example.echeckin.model;

public class Usuario {

    private int idUsuario;
    private String nomeUsuario;
    private int fkCargoUsuario;
    private String login;
    private String senha;
    private int statusUsuario;

    public void Usuario(int idUsuario, String nomeUsuario, int fkCargoUsuario, String login, String senha, int statusUsuario){
        this.setIdUsuario(idUsuario);
        this.setNomeUsuario(nomeUsuario);
        this.setFkCargoUsuario(fkCargoUsuario);
        this.setLogin(login);
        this.setSenha(senha);
        this.setStatusUsuario(statusUsuario);
    }

    public void setIdUsuario(int idUsuario){
        this.idUsuario = idUsuario;
    }

    public void setNomeUsuario(String nomeUsuario){
        this.nomeUsuario = nomeUsuario;
    }

    public void setFkCargoUsuario(int fkCargoUsuario){
        this.fkCargoUsuario = fkCargoUsuario;
    }

    public void setLogin(String login){
        this.login = login;
    }

    public void setSenha(String senha){
        this.senha = senha;
    }

    public void setStatusUsuario(int statusUsuario){
        this.statusUsuario = statusUsuario;
    }

    public int getIdUsuario(){
        return this.idUsuario;
    }

    public String nomeUsuario(){
        return this.nomeUsuario;
    }

    public int getFkCargoUsuario(){
        return this.fkCargoUsuario;
    }

    public int getStatusUsuario(){
        return this.statusUsuario;
    }

}
