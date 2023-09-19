<?php

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = User::get();
        foreach ($users as $user) {
            $user1BalanceNGN = UserBalance::create([
                'user_id' => $user->id,
                'currency_sym' => 'NGN',
                'balance' => 0,
            ]);
        
            $user2BalanceUSD = UserBalance::create([
                'user_id' => $user->id,
                'currency_sym' => 'USD',
                'balance' => 0,
            ]);
        
            $user3BalanceUSDC = UserBalance::create([
                'user_id' => $user->id,
                'currency_sym' => 'USDC',
                'balance' => 0,
            ]);
        
            $user4BalanceBTC = UserBalance::create([
                'user_id' => $user->id,
                'currency_sym' => 'BTC',
                'balance' => 0,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_balances');
    }
}
