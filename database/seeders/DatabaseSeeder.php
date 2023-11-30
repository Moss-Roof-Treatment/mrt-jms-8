<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(BuildingStylePostTypeSeeder::class);
        $this->call(SmsTemplateSeeder::class);
        $this->call(AccountClassSeeder::class);
        $this->call(AccountRoleSeeder::class);
        $this->call(ArticleCategoriesTableSeeder::class);
        $this->call(ArticleTagsTableSeeder::class);
        $this->call(BuildingStyleSeeder::class);
        $this->call(BuildingTypeSeeder::class);
        $this->call(ColoursSeeder::class);
        $this->call(DimensionSeeder::class);
        $this->call(DefaultAdditionalCommentSeeder::class);
        $this->call(DefaultEmailResponseTextSeeder::class);
        $this->call(EmailTemplateSeeder::class);
        $this->call(EquipmentCategorySeeder::class);
        $this->call(EquipmentGroupSeeder::class);
        $this->call(ExpectedPaymentMethodSeeder::class);
        $this->call(FollowUpCallStatusSeeder::class);
        $this->call(InspectionTypeSeeder::class);
        $this->call(JobProgressSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(LoginStatusSeeder::class);
        $this->call(MaterialTypeSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(PrioritySeeder::class);
        $this->call(ReminderResponseStatusSeeder::class);
        $this->call(QuoteRequestStatusesSeeder::class);
        $this->call(QuoteSentStatusSeeder::class);
        $this->call(ReferralSeeder::class);
        $this->call(RoofPitchMultiplyFactorSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(SwmsQuestionCategorySeeder::class);
        $this->call(SwmsQuestionSeeder::class);
        $this->call(TaskPriceRangeSeeder::class);
        $this->call(TaskTypeSeeder::class);
        $this->call(TermsHeadingSeeder::class);
        $this->call(TermsSubHeadingSeeder::class);
        $this->call(TermsItemSeeder::class);
        $this->call(TermsSubItemSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(SystemSeeder::class);

        $this->call(JobStatusesSeeder::class);
        $this->call(QuoteStatusesSeeder::class);

        $this->call(ProductSeeder::class);
        $this->call(RateSeeder::class);
        $this->call(TaskSeeder::class);

        $this->call(SeoTagSeeder::class);
        $this->call(SeoKeywordSeeder::class);
        $this->call(FrequentlyAskedQuestionSeeder::class);
    }
}
