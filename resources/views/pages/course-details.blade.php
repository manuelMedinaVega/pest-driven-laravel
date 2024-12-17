<h2>{{ $course->title }}</h2>
<h3>{{ $course->tagline }}</h3>
<p>{{ $course->description }}</p>
<p>{{ $course->videos_count }} videos</p>
<ul>
    @foreach($course->learnings as $learning)
        <li>{{ $learning }}</li>
    @endforeach
</ul>
<img src="{{ asset("images/$course->image_name") }}" alt="Image of the course {{ $course->title }}" >

<a href="#" onclick="openCheckout(itemsList)">Buy now</a>

<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>

<script type="text/javascript">
    @env('testing')
        Paddle.Environment.set("sandbox");
    @endenv
    @env('local')
        Paddle.Environment.set("sandbox");
    @endenv
    Paddle.Initialize({token: "{{ config('services.paddle.client_token') }}"});
    
    // define items
    let itemsList = [{priceId: "{{ $course->paddle_product_id }}"}];
    // open checkout
    function openCheckout(items){
        Paddle.Checkout.open({
            items: items
        });
    }
</script>
