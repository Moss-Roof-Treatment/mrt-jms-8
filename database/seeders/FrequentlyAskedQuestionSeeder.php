<?php

namespace Database\Seeders;

use App\Models\FrequentlyAskedQuestion;
use Illuminate\Database\Seeder;

class FrequentlyAskedQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FrequentlyAskedQuestion::create([
            'question' => "I recently had MRT applied to my roof 1 month ago nothing has changed, actually it looks worse - has it failed.",
            'answer' => "The product is a slow activating process which works over a period of time. Please read the information leaflet which shows the time frame. In regards to the roof looking worse that means that the product has worked on killing the moss & browning it off - that’s great."
        ]);

        FrequentlyAskedQuestion::create([
            'question' => "Why does it take so long?",
            'answer' => "The product has to penetrate into moss & lichen that has been growing for a very long time - so it takes time. The active ingredient in the MRT loves rain as it reactivates the process."
        ]);

        FrequentlyAskedQuestion::create([
            'question' => "Does the moss fall off in big clumps and block my downpipes?",
            'answer' => "No, the moss & lichen falls away like dust, if you were to rub some moss/lichen that has been treated with MRT, it will crumble & feel like dust under your fingers, and as the process is gradual the moss in the downpipes/gutters just flows away."
        ]);

        FrequentlyAskedQuestion::create([
            'question' => "It is suitable for solar panels?",
            'answer' => "The product is suitable for a wide range of roof surfaces including solar panels, awnings, walls, render, bricks and the list goes on."
        ]);

        FrequentlyAskedQuestion::create([
            'question' => "My roof is very steep and access is tricky, I can’t really afford the cost of scaffold, how can you apply it.",
            'answer' => "The great thing about this product is that we can apply by ladder or working platforms. The product is applied with a pressure hose and can reach a long distance allowing us to safely apply to steep & tricky roof surfaces."
        ]);

        FrequentlyAskedQuestion::create([
            'question' => "My roof has been painted and moss is growing on the surface - will The MRT disturb the paint?",
            'answer' => "When moss grows on paint it is usually on the surface so the MRT gently kills the moss and it crumbles away leaving the paint intact."
        ]);

        FrequentlyAskedQuestion::create([
            'question' => "I have lots of plants, trees & shrubs around my property is the MRT safe?",
            'answer' => "Yes, it a safe product. As an added precaution, we like to hose down any immediate plants."
        ]);

        FrequentlyAskedQuestion::create([
            'question' => "What is the best time to apply the MRT?",
            'answer' => "We recommend an overcast day and where rain is not forecast until the next day. This gives the active ingredients time to work."
        ]);

        FrequentlyAskedQuestion::create([
            'question' => "I have several water tanks; how do I avoid getting MRT into them?",
            'answer' => "We recommend diverting the pipes into the water tanks for at least 3 weeks or until there has been a good rainfall to fully flush out the gutters, then it will be fine to reconnect."
        ]);
    }
}
