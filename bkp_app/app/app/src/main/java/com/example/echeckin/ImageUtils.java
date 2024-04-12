package com.example.echeckin;

import android.content.ContentValues;
import android.content.Context;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Environment;
import android.provider.MediaStore;
import android.widget.Toast;

import java.io.File;
import java.io.FileOutputStream;
import java.io.OutputStream;

public class ImageUtils {

    public static void saveImageToGallery(Context context, Bitmap bitmap, String title) {
        // Verifica se o armazenamento externo está disponível para escrita
        String externalStorageState = Environment.getExternalStorageState();
        if (!externalStorageState.equals(Environment.MEDIA_MOUNTED)) {
            Toast.makeText(context, "Armazenamento externo não disponível", Toast.LENGTH_SHORT).show();
            return;
        }

        // Cria um diretório para armazenar a imagem
        File directory = new File(Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_PICTURES), "eCheckin");
        if (!directory.exists()) {
            directory.mkdirs();
        }

        // Cria o arquivo da imagem
        File file = new File(directory, title + ".jpg");

        try {
            // Salva a imagem no arquivo
            OutputStream outputStream = new FileOutputStream(file);
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, outputStream);
            outputStream.flush();
            outputStream.close();

            // Insere a imagem na galeria do dispositivo
            ContentValues values = new ContentValues();
            values.put(MediaStore.Images.Media.TITLE, title);
            values.put(MediaStore.Images.Media.DESCRIPTION, "QR Code");
            values.put(MediaStore.Images.Media.DATE_TAKEN, System.currentTimeMillis());
            values.put(MediaStore.Images.ImageColumns.BUCKET_ID, file.toString().toLowerCase().hashCode());
            values.put(MediaStore.Images.ImageColumns.BUCKET_DISPLAY_NAME, file.getName().toLowerCase());
            values.put("_data", file.getAbsolutePath());
            context.getContentResolver().insert(MediaStore.Images.Media.EXTERNAL_CONTENT_URI, values);

            Toast.makeText(context, "Imagem salva na galeria", Toast.LENGTH_SHORT).show();
        } catch (Exception e) {
            e.printStackTrace();
            Toast.makeText(context, "Erro ao salvar imagem", Toast.LENGTH_SHORT).show();
        }
    }
}

