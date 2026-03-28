<?php
// database/migrations/2024_01_01_000001_create_site_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->string('type')->default('text'); // text, image, boolean, number
            $table->timestamps();
        });

        // Seed default values
        $defaults = [
            // Rekening Bank
            ['key' => 'bank_count',      'value' => '3', 'group' => 'bank', 'type' => 'number'],

            ['key' => 'bank_1_name',     'value' => 'BCA',              'group' => 'bank'],
            ['key' => 'bank_1_number',   'value' => '1234567890',        'group' => 'bank'],
            ['key' => 'bank_1_owner',    'value' => 'HPMI Pusat',        'group' => 'bank'],
            ['key' => 'bank_1_active',   'value' => '1',                 'group' => 'bank', 'type' => 'boolean'],

            ['key' => 'bank_2_name',     'value' => 'Mandiri',           'group' => 'bank'],
            ['key' => 'bank_2_number',   'value' => '0987654321',        'group' => 'bank'],
            ['key' => 'bank_2_owner',    'value' => 'HPMI Pusat',        'group' => 'bank'],
            ['key' => 'bank_2_active',   'value' => '1',                 'group' => 'bank', 'type' => 'boolean'],

            ['key' => 'bank_3_name',     'value' => 'BNI',               'group' => 'bank'],
            ['key' => 'bank_3_number',   'value' => '1122334455',        'group' => 'bank'],
            ['key' => 'bank_3_owner',    'value' => 'HPMI Pusat',        'group' => 'bank'],
            ['key' => 'bank_3_active',   'value' => '1',                 'group' => 'bank', 'type' => 'boolean'],

            ['key' => 'bank_4_name',     'value' => '',                  'group' => 'bank'],
            ['key' => 'bank_4_number',   'value' => '',                  'group' => 'bank'],
            ['key' => 'bank_4_owner',    'value' => '',                  'group' => 'bank'],
            ['key' => 'bank_4_active',   'value' => '0',                 'group' => 'bank', 'type' => 'boolean'],

            ['key' => 'bank_5_name',     'value' => '',                  'group' => 'bank'],
            ['key' => 'bank_5_number',   'value' => '',                  'group' => 'bank'],
            ['key' => 'bank_5_owner',    'value' => '',                  'group' => 'bank'],
            ['key' => 'bank_5_active',   'value' => '0',                 'group' => 'bank', 'type' => 'boolean'],

            // Organisasi
            ['key' => 'org_name',        'value' => 'Himpunan Perawat Manajer Indonesia', 'group' => 'general'],
            ['key' => 'org_tagline',     'value' => 'Bersama Membangun Keperawatan Manajerial Indonesia', 'group' => 'general'],
            ['key' => 'org_description', 'value' => '', 'group' => 'general'],
            ['key' => 'contact_email',   'value' => '', 'group' => 'general'],
            ['key' => 'contact_phone',   'value' => '', 'group' => 'general'],
            ['key' => 'contact_address', 'value' => '', 'group' => 'general'],

            // Hero
            ['key' => 'hero_badge_text',    'value' => 'Organisasi Profesi Keperawatan Indonesia', 'group' => 'homepage'],
            ['key' => 'hero_title',         'value' => 'Himpunan Perawat', 'group' => 'homepage'],
            ['key' => 'hero_title_accent',  'value' => 'Manajer Indonesia', 'group' => 'homepage'],
            ['key' => 'hero_subtitle',      'value' => 'Bersama membangun kompetensi dan profesionalisme perawat manajer di seluruh Indonesia.', 'group' => 'homepage'],
            ['key' => 'hero_cta_primary',   'value' => 'Gabung Sekarang', 'group' => 'homepage'],
            ['key' => 'hero_cta_secondary', 'value' => 'Tentang HPMI', 'group' => 'homepage'],

            // Banner slides (5 slide)
            ['key' => 'banner_slide_1_title',    'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_1_subtitle', 'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_1_image',    'value' => '', 'group' => 'banner', 'type' => 'image'],
            ['key' => 'banner_slide_1_link',     'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_1_color',    'value' => '#1a4e8a', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_1_active',   'value' => '1', 'group' => 'banner', 'type' => 'boolean'],

            ['key' => 'banner_slide_2_title',    'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_2_subtitle', 'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_2_image',    'value' => '', 'group' => 'banner', 'type' => 'image'],
            ['key' => 'banner_slide_2_link',     'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_2_color',    'value' => '#1a4e8a', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_2_active',   'value' => '1', 'group' => 'banner', 'type' => 'boolean'],

            ['key' => 'banner_slide_3_title',    'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_3_subtitle', 'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_3_image',    'value' => '', 'group' => 'banner', 'type' => 'image'],
            ['key' => 'banner_slide_3_link',     'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_3_color',    'value' => '#1a4e8a', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_3_active',   'value' => '1', 'group' => 'banner', 'type' => 'boolean'],

            ['key' => 'banner_slide_4_title',    'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_4_subtitle', 'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_4_image',    'value' => '', 'group' => 'banner', 'type' => 'image'],
            ['key' => 'banner_slide_4_link',     'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_4_color',    'value' => '#1a4e8a', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_4_active',   'value' => '1', 'group' => 'banner', 'type' => 'boolean'],

            ['key' => 'banner_slide_5_title',    'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_5_subtitle', 'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_5_image',    'value' => '', 'group' => 'banner', 'type' => 'image'],
            ['key' => 'banner_slide_5_link',     'value' => '', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_5_color',    'value' => '#1a4e8a', 'group' => 'banner', 'type' => 'text'],
            ['key' => 'banner_slide_5_active',   'value' => '1', 'group' => 'banner', 'type' => 'boolean'],

            // CTA
            ['key' => 'cta_title',       'value' => 'Bergabunglah dengan HPMI', 'group' => 'homepage'],
            ['key' => 'cta_subtitle',    'value' => 'Tingkatkan kompetensi Anda bersama ribuan perawat manajer profesional.', 'group' => 'homepage'],
            ['key' => 'cta_button_text', 'value' => 'Daftar Sekarang', 'group' => 'homepage'],

            // Fitur
            ['key' => 'feature_registration',       'value' => '1', 'group' => 'feature', 'type' => 'boolean'],
            ['key' => 'feature_virtual_payment',    'value' => '0', 'group' => 'feature', 'type' => 'boolean'],
            ['key' => 'feature_maintenance',        'value' => '0', 'group' => 'feature', 'type' => 'boolean'],
            ['key' => 'feature_email_notification', 'value' => '1', 'group' => 'feature', 'type' => 'boolean'],
            ['key' => 'feature_article_comment',    'value' => '1', 'group' => 'feature', 'type' => 'boolean'],
            ['key' => 'feature_dark_mode',          'value' => '0', 'group' => 'feature', 'type' => 'boolean'],

            // Billing
            ['key' => 'billing_registration_fee',      'value' => '150000', 'group' => 'billing', 'type' => 'number'],
            ['key' => 'billing_annual_fee',             'value' => '300000', 'group' => 'billing', 'type' => 'number'],
            ['key' => 'billing_membership_duration',    'value' => '1 Tahun', 'group' => 'billing'],

            // Sosial media
            ['key' => 'social_facebook',  'value' => '', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social'],
            ['key' => 'social_youtube',   'value' => '', 'group' => 'social'],
            ['key' => 'social_linkedin',  'value' => '', 'group' => 'social'],
        ];

        foreach ($defaults as $item) {
            \DB::table('site_settings')->insert(array_merge([
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ], $item));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
