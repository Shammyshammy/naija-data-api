<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            // [name, CBN code, type]
            ['Access Bank',                  '044', 'commercial'],
            ['Citibank Nigeria',             '023', 'commercial'],
            ['Ecobank Nigeria',              '050', 'commercial'],
            ['Fidelity Bank',                '070', 'commercial'],
            ['First Bank of Nigeria',        '011', 'commercial'],
            ['First City Monument Bank',     '214', 'commercial'],
            ['Guaranty Trust Bank',          '058', 'commercial'],
            ['Heritage Bank',                '030', 'commercial'],
            ['Keystone Bank',                '082', 'commercial'],
            ['Polaris Bank',                 '076', 'commercial'],
            ['Providus Bank',                '101', 'commercial'],
            ['Stanbic IBTC Bank',            '221', 'commercial'],
            ['Standard Chartered Bank',      '068', 'commercial'],
            ['Sterling Bank',                '232', 'commercial'],
            ['Suntrust Bank',                '100', 'commercial'],
            ['Union Bank of Nigeria',        '032', 'commercial'],
            ['United Bank for Africa',       '033', 'commercial'],
            ['Unity Bank',                   '215', 'commercial'],
            ['Wema Bank',                    '035', 'commercial'],
            ['Zenith Bank',                  '057', 'commercial'],
            ['Kuda Bank',                    '50211', 'microfinance'],
            ['Opay Digital Services',        '999992', 'microfinance'],
            ['PalmPay',                      '999991', 'microfinance'],
            ['Moniepoint MFB',               '50515', 'microfinance'],
            ['Carbon',                       '565', 'microfinance'],
            ['VBank',                        '566', 'microfinance'],
            ['Rubies MFB',                   '125', 'microfinance'],
            ['Sparkle Microfinance Bank',    '51310', 'microfinance'],
            ['TajBank',                      '302', 'non_interest'],
            ['Jaiz Bank',                    '301', 'non_interest'],
            ['Lotus Bank',                   '303', 'non_interest'],
            ['Rand Merchant Bank',           '502', 'merchant'],
            ['Providus Bank Merchant',       '562', 'merchant'],
            ['Coronation Merchant Bank',     '559', 'merchant'],
            ['FSDH Merchant Bank',           '501', 'merchant'],
            ['Nova Merchant Bank',           '561', 'merchant'],
        ];

        foreach ($banks as $b) {
            Bank::create([
                'name'      => $b[0],
                'slug'      => Str::slug($b[0]),
                'code'      => $b[1],
                'type'      => $b[2],
                'is_active' => true,
            ]);
        }
    }
}