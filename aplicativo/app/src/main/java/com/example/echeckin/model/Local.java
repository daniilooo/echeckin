package com.example.echeckin.model;

public class Local {

    private int idLocal;
    private int fkEmpresa;
    private String descLocal;
    private int statusLocal;

    public void Local(int idLocal, int fkEmpresa, String descLocal, int statusLocal){
        this.setIdLocal(idLocal);
        this.setFkEmpresa(fkEmpresa);
        this.setDescLocal(descLocal);
        this.setStatusLocal(statusLocal);
    }

    public void setIdLocal(int idLocal){
        this.idLocal = idLocal;
    }

    public void setFkEmpresa(int fkEmpresa){
        this.fkEmpresa = fkEmpresa;
    }

    public void setDescLocal(String descLocal){
        this.descLocal = descLocal;
    }

    public void setStatusLocal(int statusLocal){
        this.statusLocal = statusLocal;
    }

    public int getIdLocal(){
        return this.idLocal;
    }

    public int getFkEmpresa(){
        return this.fkEmpresa;
    }

    public String getDescLocal(){
        return this.descLocal;
    }

    public int getStatusLocal(){
        return this.statusLocal;
    }
}
