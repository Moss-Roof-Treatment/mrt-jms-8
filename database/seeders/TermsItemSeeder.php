<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TermsItem;

class TermsItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“Agreement” means this Agreement comprise of Section 1, Scope of Engagement, these terms and conditions and any documents expressly incorporated by reference.',
        ]);

        // 2
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“Business Day” means a day which is not a Saturday, Sunday, public holiday or bank holiday in the applicable State in Australia.',
        ]);

        // 3
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“Client” means the Party engaging MRT to provide the Services as defined in Section 1.',
        ]);

        // 4
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“Confidential Information” means information or documents provided to, received by or produced by a Party in respect of the Services but excluding information that is generally available to the public or is known to a Party before the date of this Agreement.',
        ]);

        // 5
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“Fees” means the amount payable to MRT for providing the Services, based on the rates set out in Section 1.',
        ]);

        // 6
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“Party” means a Party to this Agreement and includes all assignees, employees, agents or sub-contractors.',
        ]);

        // 7
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“MRT" means Moss Roof Treatment Pty Ltd ACN: 635 776 242.',
        ]);

        // 8
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“Services” means the services described in Section 1.',
        ]);

        // 9
        TermsItem::create([
            'terms_sub_heading_id' => 1,
            'text' => '“Third Party” means any other party who is not a party to this Agreement.',
        ]);

        // 10
        TermsItem::create([
            'terms_sub_heading_id' => 2,
            'text' => 'provide MRT and its workers with access to your property as is reasonably necessary to perform the Services;',
        ]);

        // 11
        TermsItem::create([
            'terms_sub_heading_id' => 2,
            'text' => 'provide MRT with connections to power and water supply, at the Client’s cost; ',
        ]);

        // 12
        TermsItem::create([
            'terms_sub_heading_id' => 2,
            'text' => 'ensure that children and pets are kept away from MRT’s workmen whilst on your property;',
        ]);

        // 13
        TermsItem::create([
            'terms_sub_heading_id' => 2,
            'text' => 'disconnect water tanks that collect run-off from treated areas prior to MRT commencing performance of the Services and keep disconnected for 2-3 weeks or 7-8mm of rain after the treatment has been applied.',
        ]);

        // 14
        TermsItem::create([
            'terms_sub_heading_id' => 2,
            'text' => 'stay clear of MRT workers whilst the Services are being performed and not walk on areas that have ben treated by MRT.',
        ]);

        // 15
        TermsItem::create([
            'terms_sub_heading_id' => 4,
            'text' => 'provide the Services in a timely manner and with the appropriate professional skill and expertise;',
        ]);

        // 16
        TermsItem::create([
            'terms_sub_heading_id' => 4,
            'text' => 'comply with any reasonable direction given by the Client in relation to the Services;',
        ]);

        // 17
        TermsItem::create([
            'terms_sub_heading_id' => 4,
            'text' => 'endeavour to adhere to any timeframes required by the Client however, unless otherwise expressly agreed, the timeframes provided to the Client are intended for planning and estimating purposes only and are not legally binding; and ',
        ]);

        // 18
        TermsItem::create([
            'terms_sub_heading_id' => 4,
            'text' => 'will not be liable for any failure or delay in performing the Services if that failure arises from anything beyond MRT’s reasonable control or the failure of the Client to comply with this Agreement.',
        ]);

        // 19
        TermsItem::create([
            'terms_sub_heading_id' => 5,
            'text' => 'The Client agrees to pay the quoted fees immediately upon completion of the Services.',
        ]);

        // 20
        TermsItem::create([
            'terms_sub_heading_id' => 5,
            'text' => 'MRT reserves the right to send you a legal demand or commence legal proceedings in respect of any amounts owing to MRT that remain unpaid for 14 days. We may exercise our rights without prior notice to you ',
        ]);

        // 21
        TermsItem::create([
            'terms_sub_heading_id' => 5,
            'text' => 'The Client will be required to pay:',
        ]);

        // 22
        TermsItem::create([
            'terms_sub_heading_id' => 6,
            'text' => 'MRT’s Fees are exclusive of GST, unless stated otherwise. Any applicable GST will be added to the fee in a tax invoice and will be paid by the Client.',
        ]);

        // 23
        TermsItem::create([
            'terms_sub_heading_id' => 7,
            'text' => 'The parties, and any employees, agents or sub-contractors of the parties, must not disclose Confidential Information belonging to the other party without the other’s prior written consent unless the disclosure is to:',
        ]);

        // 24
        TermsItem::create([
            'terms_sub_heading_id' => 7,
            'text' => 'This clause shall survive termination of the Agreement.',
        ]);

        // 25
        TermsItem::create([
            'terms_sub_heading_id' => 8,
            'text' => 'MRT guarantees that following performance of the Services, no new moss will grow within areas treated by MRT for a period of 3 years.',
        ]);

        // 26
        TermsItem::create([
            'terms_sub_heading_id' => 8,
            'text' => 'In the event that the guarantee under clause 7(a) is not achieved, MRT agrees to re-perform the Services at MRT’s costs, to the affected areas.',
        ]);

        // 27
        TermsItem::create([
            'terms_sub_heading_id' => 9,
            'text' => 'The parties acknowledge that, under applicable State and Commonwealth law, certain conditions and warranties may be implied in this Agreement and there are rights and remedies conferred on the Client in relation to the provision of the Services which cannot be excluded, restricted or modified by the Agreement (“Non-excludable Rights”).',
        ]);

        // 28
        TermsItem::create([
            'terms_sub_heading_id' => 9,
            'text' => 'To the extent permitted by law, MRT excludes all liability for any indirect or consequential loss or damage, loss of profit, loss of opportunity, loss of business or loss of goodwill arising as a result of the performance of the Services.',
        ]);

        // 29
        TermsItem::create([
            'terms_sub_heading_id' => 9,
            'text' => 'To the extent permitted by law and subject to the Non-Excludable Rights, MRT’s liability to the Client is limited to, at MRT’s option, supplying the Services again or paying the cost of having the Services supplied again. MRT is not liable to any third party that is not the Client and excludes all liability whatsoever to such parties arising out of or in connection with the Services.',
        ]);

        // 30
        TermsItem::create([
            'terms_sub_heading_id' => 9,
            'text' => 'MRT will not be liable for any breach, failure or other act or omission arising under or in connection with this Agreement to the extent that such breach, failure or other act or omission is caused or contributed to by any party other than MRT. Such failure may include failure to adhere to the recommendations set out in the Safety Data Sheet provided to the Client. Without limitation, MRT excludes any liability for loss or damage to:',
        ]);

        // 31
        TermsItem::create([
            'terms_sub_heading_id' => 9,
            'text' => 'To the extent permitted by law, MRT its employees and any agents or contractors will not be liable for and the Client will indemnify and hold harmless against any claims, actions, expenses (including all reasonable legal expenses), loss or damages of a Third Party resulting from or arising out of the provision of Services by MRT.',
        ]);

        // 32
        TermsItem::create([
            'terms_sub_heading_id' => 10,
            'text' => 'Variation This Agreement may only be varied by written agreement, as mutually agreed by the parties.',
        ]);

        // 33
        TermsItem::create([
            'terms_sub_heading_id' => 10,
            'text' => 'Assignment Unless MRT expressly consents, the Client must not assign any obligation, entitlement, charge or otherwise deal with MRT rights or obligations under this Agreement.',
        ]);

        // 34
        TermsItem::create([
            'terms_sub_heading_id' => 10,
            'text' => 'Governing Law and Jurisdiction This Agreement is governed by the law in force in the State of Victoria and the parties submit to the non-exclusive jurisdiction of the courts of that State or Territory in respect of any proceedings in connection with these Terms and Conditions.',
        ]);

    }
}
