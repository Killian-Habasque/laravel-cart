<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductsList extends Component
{

    public function increment($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $product = Product::find($id);
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        $this->dispatch('update-cart');
    }

    public function decrement($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        } else {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);

        $this->dispatch('update-cart');
    }

    #[On('update-list')]
    public function render()
    {
        $products = Product::get();

        return view('livewire.products-list', compact('products'));
    }
}
