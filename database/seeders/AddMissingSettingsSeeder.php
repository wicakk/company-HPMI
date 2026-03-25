<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class AddMissingSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // BILLING
            ['key' => 'billing_registration_fee', 'value' => '150000', 'group' => 'billing', 'type' => 'number'],
            ['key' => 'billing_annual_fee', 'value' => '300000', 'group' => 'billing', 'type' => 'number'],
            ['key' => 'billing_membership_duration', 'value' => '1 Tahun', 'group' => 'billing', 'type' => 'text'],

            // FEATURES
            ['key' => 'feature_registration', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_virtual_payment', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_maintenance', 'value' => '0', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_email_notification', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_article_comment', 'value' => '0', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_dark_mode', 'value' => '0', 'group' => 'features', 'type' => 'boolean'],

            // SOCIAL
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/hpmi.id', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/hpmi.id', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@hpmi', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/hpmi', 'group' => 'social', 'type' => 'text'],

            // GENERAL (tambahan)
            ['key' => 'site_tagline', 'value' => 'Bersama Membangun Keperawatan Manajerial Indonesia', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_address', 'value' => 'Jl. Kesehatan No. 1, Jakarta Pusat 10110', 'group' => 'general', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}