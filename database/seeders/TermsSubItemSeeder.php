<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TermsSubItem;

class TermsSubItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TermsSubItem::create([
            'terms_item_id' => 21,
            'text' => 'any additional costs or fees incurred by MRT as a result of delay by the Client in providing MRT with access to the property to perform the Services:',
        ]);

        TermsSubItem::create([
            'terms_item_id' => 21,
            'text' => 'a cancellation fee of 50% of the quoted fees in respect of any booking for Services that is cancelled within 48 hours of the date of the Service booking set out in the quote.',
        ]);

        TermsSubItem::create([
            'terms_item_id' => 23,
            'text' => 'a Third Party in relation to the provision of the Services;',
        ]);

        TermsSubItem::create([
            'terms_item_id' => 23,
            'text' => 'the insurers or legal advisors of a party;',
        ]);

        TermsSubItem::create([
            'terms_item_id' => 23,
            'text' => 'required by law or a regulatory authority.',
        ]);

        TermsSubItem::create([
            'terms_item_id' => 30,
            'text' => 'real property, fixtures and fittings;',
        ]);

        TermsSubItem::create([
            'terms_item_id' => 30,
            'text' => 'personal property which is left within the vicinity of, or in direct exposure to the Services; and',
        ]);

        TermsSubItem::create([
            'terms_item_id' => 30,
            'text' => 'injury or death of pets.',
        ]);
    }
}
