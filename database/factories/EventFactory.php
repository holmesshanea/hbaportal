<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+7 days', '+60 days');
        $end   = (clone $start);
        $end->modify('+' . $this->faker->numberBetween(1, 3) . ' days');

        return [
            'event_type' => 'event',

            'title' => $this->faker->sentence(4),
            'short_description' => $this->faker->sentence(12),
            'description' => $this->faker->paragraphs(3, true),

            // These appear to exist in your table (based on the insert list)
            'start_date' => Carbon::instance($start)->toDateString(),
            'end_date'   => Carbon::instance($end)->toDateString(),
            'start_time' => Carbon::instance($start)->format('h:i A'),
            'end_time'   => Carbon::instance($start)->copy()->addHours(2)->format('h:i A'),

            // This appears to exist in your table (from your migration snippet)
            'image' => null,
        ];
    }

    public function retreat(): static
    {
        return $this->state(function () {
            $start = $this->faker->dateTimeBetween('+14 days', '+90 days');
            $end   = (clone $start);
            $end->modify('+2 days');

            return [
                'event_type' => 'retreat',
                'title' => 'Veteran Nature Retreat',
                'short_description' => 'A three-day retreat focused on nature, connection, and support.',
                'description' => $this->faker->paragraphs(4, true),

                'start_date' => Carbon::instance($start)->toDateString(),
                'end_date'   => Carbon::instance($end)->toDateString(),

                // OPTIONAL: if you want retreats to have no times, uncomment:
                // 'start_time' => null,
                // 'end_time'   => null,
            ];
        });
    }

    public function event(): static
    {
        return $this->state(fn () => [
            'event_type' => 'event',
        ]);
    }
}
