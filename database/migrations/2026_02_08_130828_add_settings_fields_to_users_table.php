<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_path')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('avatar_path');
            $table->string('account_holder')->nullable()->after('bio');
            $table->string('iban', 34)->nullable()->after('account_holder');
            $table->string('bic', 11)->nullable()->after('iban');
            $table->string('bank_name')->nullable()->after('bic');
            $table->boolean('auto_confirm_visits')->default(false)->after('bank_name');
            $table->boolean('receive_visit_reminders')->default(true)->after('auto_confirm_visits');
            $table->integer('max_response_time')->default(24)->after('receive_visit_reminders');
            $table->string('preferred_contact_method')->nullable()->after('max_response_time');
            $table->json('notification_preferences')->nullable()->after('preferred_contact_method');
            $table->json('settings')->nullable()->after('notification_preferences');
            $table->timestamp('last_login_at')->nullable()->after('settings');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar_path',
                'bio',
                'account_holder',
                'iban',
                'bic',
                'bank_name',
                'auto_confirm_visits',
                'receive_visit_reminders',
                'max_response_time',
                'preferred_contact_method',
                'notification_preferences',
                'settings',
                'last_login_at',
            ]);
        });
    }
};