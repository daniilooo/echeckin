package com.example.echeckin;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.hardware.camera2.CameraAccessException;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.provider.MediaStore;
import android.util.Log;
import android.view.TextureView;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;
import android.hardware.camera2.CameraManager;


import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class MainActivity extends AppCompatActivity {

    private static final int REQUEST_CAMERA_PERMISSION = 100;
    private static final int REQUEST_CODE_IMAGE_CAPTURE = 101;

    private TextureView textureView;
    private Button btnCheckin, btnAcenderFlash;
    private boolean isFlashlightOn = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Initialize views
        textureView = findViewById(R.id.textureView);
        btnCheckin = findViewById(R.id.btnCheckin);
        btnAcenderFlash = findViewById(R.id.btnAcenderFlash);

        // Check camera permission
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.CAMERA) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.CAMERA}, REQUEST_CAMERA_PERMISSION);
        }

        // Set click event to the button
        btnCheckin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Start QR scanner
                startQRScanner();
            }
        });

        btnAcenderFlash.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                acenderFlash();
            }
        });
    }

    // Method to toggle flashlight
    private void acenderFlash() {
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.CAMERA) == PackageManager.PERMISSION_GRANTED) {
            CameraManager cameraManager = (CameraManager) getSystemService(Context.CAMERA_SERVICE);
            try {
                String cameraId = cameraManager.getCameraIdList()[0];
                cameraManager.setTorchMode(cameraId, !isFlashlightOn);
                isFlashlightOn = !isFlashlightOn;
                btnAcenderFlash.setText(isFlashlightOn ? "Desligar lanterna" : "Ligar lanterna");
            } catch (CameraAccessException e) {
                e.printStackTrace();
                Toast.makeText(this, "Failed to toggle flashlight", Toast.LENGTH_SHORT).show();
            }
        } else {
            Toast.makeText(this, "Camera permission is required", Toast.LENGTH_SHORT).show();
        }
    }


    // Method to start QR scanner
    private void startQRScanner() {
        // Check camera permission again before starting the scanner
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.CAMERA) == PackageManager.PERMISSION_GRANTED) {
            // Toggle flashlight on
            acenderFlash();

            // Start QR scanner after a short delay (to ensure flashlight is on)
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    IntentIntegrator integrator = new IntentIntegrator(MainActivity.this);
                    integrator.setPrompt("Escaneie o QR Code"); // Prompt to display to the user
                    integrator.initiateScan(); // Start QR Code scanner activity
                }
            }, 500); // Delay of 500 milliseconds
        } else {
            Toast.makeText(this, "Camera permission is required", Toast.LENGTH_SHORT).show();
        }
    }


    // Method to handle the result of QR scanner
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        IntentResult result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        if (result != null && result.getContents() != null) {
            String qrCodeContent = result.getContents();
            Toast.makeText(this, "Realizando checkin: " + qrCodeContent, Toast.LENGTH_SHORT).show();

            // Take screenshot and save
            takeScreenshot();
        }
    }

    // Method to take screenshot and save
    private void takeScreenshot() {
        // Check if textureView is available
        if (textureView.isAvailable()) {
            // Get the bitmap of the texture view (camera preview)
            Bitmap bitmap = textureView.getBitmap();

            // Rotate the bitmap by 90 degrees
            Matrix matrix = new Matrix();
            matrix.postRotate(90);
            bitmap = Bitmap.createBitmap(bitmap, 0, 0, bitmap.getWidth(), bitmap.getHeight(), matrix, true);

            // Save the screenshot to external storage
            saveBitmap(bitmap);
        } else {
            Toast.makeText(this, "TextureView is not available", Toast.LENGTH_SHORT).show();
        }
    }

    // Method to save the screenshot
    private void saveBitmap(Bitmap bitmap) {
        // Define the directory to save the screenshot
        String folderPath = Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_PICTURES).getPath() + "/eCheckin";
        File folder = new File(folderPath);
        if (!folder.exists()) {
            folder.mkdirs();
        }

        // Generate file name for the screenshot
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String fileName = "Screenshot_" + timeStamp + ".jpg";

        // Save the screenshot
        File file = new File(folder, fileName);
        try {
            FileOutputStream fos = new FileOutputStream(file);
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, fos);
            fos.flush();
            fos.close();
            Toast.makeText(this, "Salvando evidência: " + file.getAbsolutePath(), Toast.LENGTH_SHORT).show();
        } catch (IOException e) {
            e.printStackTrace();
            Toast.makeText(this, "Não foi possível salvar a evidência", Toast.LENGTH_SHORT).show();
        }
    }

    // Handle permission request result
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == REQUEST_CAMERA_PERMISSION) {
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                // Camera permission granted
                // You may initialize your camera here if required
            } else {
                // Camera permission denied
                Toast.makeText(this, "Camera permission is required", Toast.LENGTH_SHORT).show();
            }
        }
    }
}