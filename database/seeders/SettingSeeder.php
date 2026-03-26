<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Group: general
            ['key' => 'org_name',            'value' => 'Himpunan Perawat Manajer Indonesia', 'group' => 'general',  'type' => 'text'],
            ['key' => 'org_tagline',         'value' => 'Bersama Membangun Keperawatan Manajerial Indonesia',       'group' => 'general',  'type' => 'text'],
            ['key' => 'org_description',     'value' => 'Bersama membangun kompetensi dan profesionalisme perawat manajer di seluruh Indonesia.', 'group' => 'general', 'type' => 'textarea'],

            // Group: contact
            ['key' => 'contact_email',       'value' => 'sekretariat@hpmi.id',   'group' => 'contact', 'type' => 'email'],
            ['key' => 'contact_phone',       'value' => '021-12345678',           'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_address',     'value' => 'Jl. Kesehatan No. 1, Jakarta Pusat 10110', 'group' => 'contact', 'type' => 'textarea'],

            // Group: social
            ['key' => 'social_facebook',     'value' => '',  'group' => 'social', 'type' => 'url'],
            ['key' => 'social_instagram',    'value' => '',  'group' => 'social', 'type' => 'url'],
            ['key' => 'social_youtube',      'value' => '',  'group' => 'social', 'type' => 'url'],
            ['key' => 'social_linkedin',     'value' => '',  'group' => 'social', 'type' => 'url'],

            // Group: hero (homepage)
            ['key' => 'hero_title',          'value' => 'Himpunan Perawat',                          'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_title_accent',   'value' => 'Manajer Indonesia',                         'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_subtitle',       'value' => 'Bersama membangun kompetensi dan profesionalisme perawat manajer di seluruh Indonesia.', 'group' => 'hero', 'type' => 'textarea'],
            ['key' => 'hero_badge_text',     'value' => 'Organisasi Profesi Keperawatan Indonesia',  'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_cta_primary',    'value' => 'Gabung Sekarang',   'group' => 'hero', 'type' => 'text'],
            ['key' => 'hero_cta_secondary',  'value' => 'Tentang HPMI',      'group' => 'hero', 'type' => 'text'],

            // Group: cta (bottom section)
            ['key' => 'cta_title',           'value' => 'Bergabunglah dengan HPMI', 'group' => 'cta', 'type' => 'text'],
            ['key' => 'cta_subtitle',        'value' => 'Tingkatkan kompetensi Anda bersama ribuan perawat manajer profesional di seluruh Indonesia.', 'group' => 'cta', 'type' => 'textarea'],
            ['key' => 'cta_button_text',     'value' => 'Daftar Sekarang',   'group' => 'cta', 'type' => 'text'],

            // Group: features
            ['key' => 'feature_registration',       'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_virtual_payment',    'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_maintenance',        'value' => '0', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_email_notification', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_article_comment',    'value' => '0', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_dark_mode',          'value' => '0', 'group' => 'features', 'type' => 'boolean'],

            // Group: billing
            ['key' => 'billing_registration_fee',       'value' => '150000',  'group' => 'billing', 'type' => 'number'],
            ['key' => 'billing_annual_fee',             'value' => '300000',  'group' => 'billing', 'type' => 'number'],
            ['key' => 'billing_membership_duration',    'value' => '1 Tahun', 'group' => 'billing', 'type' => 'select'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}