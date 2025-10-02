<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Support\Facades\Storage;

class QRCodeService
{
    /**
     * Check if GD extension is available for PNG generation
     */
    private function isGdAvailable(): bool
    {
        return extension_loaded('gd');
    }

    /**
     * Get the best available format (SVG if GD not available, PNG if available)
     */
    private function getBestFormat(string $preferredFormat = 'png'): string
    {
        if ($preferredFormat === 'png' && !$this->isGdAvailable()) {
            return 'svg';
        }
        return $preferredFormat;
    }
    /**
     * Generate QR code for customer warranty
     */
    public function generateWarrantyQR(string $customer_id, string $format = 'svg'): string
    {
        $url = config('app.frontend_url', 'https://prime-mobile-topaz.vercel.app') . '/customer/' . $customer_id;
        $format = $this->getBestFormat($format);
        
        $builder = new Builder(
            writer: $format === 'svg' ? new SvgWriter() : new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        $result = $builder->build();

        // Save QR code to storage
        $filename = 'qr-codes/warranty-' . $customer_id . '.' . $format;
        Storage::disk('public')->put($filename, $result->getString());

        return $filename;
    }

    /**
     * Generate QR code with logo
     */
    public function generateWarrantyQRWithLogo(string $customer_id, string $format = 'svg'): string
    {
        $url = config('app.frontend_url', 'https://prime-mobile-topaz.vercel.app') . '/customer/' . $customer_id;
        $format = $this->getBestFormat($format);
        
        // Check if logo exists
        $logoPath = public_path('assets/img/logo/logo.jpg');
        $logoResizeToWidth = null;
        if (file_exists($logoPath)) {
            $logoResizeToWidth = 50;
        } else {
            // If logo doesn't exist, don't pass logoPath to avoid errors
            $logoPath = null;
        }
        
        $builder = new Builder(
            writer: $format === 'svg' ? new SvgWriter() : new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            logoPath: $logoPath,
            logoResizeToWidth: $logoResizeToWidth,
            logoPunchoutBackground: $format === 'png' // Only enable punchout for PNG format
        );

        $result = $builder->build();

        // Save QR code to storage
        $filename = 'qr-codes/warranty-' . $customer_id . '.' . $format;
        Storage::disk('public')->put($filename, $result->getString());

        return $filename;
    }

    /**
     * Get QR code data URI for inline display
     */
    public function getQRCodeDataUri(string $customer_id, string $format = 'svg'): string
    {
        $url = config('app.frontend_url', 'https://prime-mobile-topaz.vercel.app') . '/customer/' . $customer_id;
        $format = $this->getBestFormat($format);
        
        $builder = new Builder(
            writer: $format === 'svg' ? new SvgWriter() : new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 200,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        $result = $builder->build();

        $mimeType = $format === 'svg' ? 'image/svg+xml' : 'image/png';
        return 'data:' . $mimeType . ';base64,' . base64_encode($result->getString());
    }

    /**
     * Generate QR code for customer voucher
     */
    public function generateVoucherQR(string $voucher_code, string $format = 'svg'): string
    {
        $url = config('app.frontend_url', 'https://prime-mobile-topaz.vercel.app') . '/voucher/' . $voucher_code;
        $format = $this->getBestFormat($format);
        
        $builder = new Builder(
            writer: $format === 'svg' ? new SvgWriter() : new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        $result = $builder->build();

        // Save QR code to storage
        $filename = 'qr-codes/voucher-' . $voucher_code . '.' . $format;
        Storage::disk('public')->put($filename, $result->getString());

        return $filename;
    }

    /**
     * Generate QR code for voucher with logo
     */
    public function generateVoucherQRWithLogo(string $voucher_code, string $format = 'svg'): string
    {
        $url = config('app.frontend_url', 'https://prime-mobile-topaz.vercel.app') . '/voucher/' . $voucher_code;
        $format = $this->getBestFormat($format);
        
        // Check if logo exists
        $logoPath = public_path('assets/img/logo/logo.jpg');
        $logoResizeToWidth = null;
        if (file_exists($logoPath)) {
            $logoResizeToWidth = 50;
        } else {
            $logoPath = null;
        }
        
        $builder = new Builder(
            writer: $format === 'svg' ? new SvgWriter() : new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            logoPath: $logoPath,
            logoResizeToWidth: $logoResizeToWidth,
            logoPunchoutBackground: $format === 'png'
        );

        $result = $builder->build();

        // Save QR code to storage
        $filename = 'qr-codes/voucher-' . $voucher_code . '.' . $format;
        Storage::disk('public')->put($filename, $result->getString());

        return $filename;
    }

    /**
     * Delete QR code file
     */
    public function deleteQRCode(string $customer_id, string $format = 'svg'): bool
    {
        $filename = 'qr-codes/warranty-' . $customer_id . '.' . $format;
        return Storage::disk('public')->delete($filename);
    }

    /**
     * Delete voucher QR code file
     */
    public function deleteVoucherQRCode(string $voucher_code, string $format = 'svg'): bool
    {
        $filename = 'qr-codes/voucher-' . $voucher_code . '.' . $format;
        return Storage::disk('public')->delete($filename);
    }
}
