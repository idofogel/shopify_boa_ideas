<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<div>
    <div class="head_line {{ isset($products) ? 'products_headline' : (isset($product) ? 'product_headline' : 'collection_headline') }}">
        <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
        @isset($collection)<!--this part is for the collection page-->
            <div class="sub-headline">Collection details:</div>
            <div>
                <span>Shopify ID:</span>{{$collection->collection_shopify_id}}<br />
                <span>Title:</span>{{$collection->title}}<br />
                <span>Description:</span>{{$collection->description}}<br />
                <span>Handle:</span>{{$collection->handle}}<br />
                <span class="paint-sync">last sync: {{$update_date === null ? 'app not updated yet' : $update_date['updated_at']}}</span><br />
            </div>
        @endisset

        @isset($product)
            <div class="sub-headline">Product details:</div>
            <div>
                <span>Shopify ID:</span>{{$product->shopify_id}}<br />
                <span>Title:</span>{{$product->title}}<br />
                <span>Description:</span>{{$product->description}}<br />
                <span>Handle:</span>{{$product->handle}}<br />
                <span>Status:</span>{{$product->status}}<br />
                <span>Minimum price of the variants:</span>{{$product->min_variant_compare}}<br />
                <span>Maximum price of the variants:</span>{{$product->max_variant_compare}}<br />
                <span class="paint-sync">last sync: {{$update_date === null ? 'app not updated yet' : $update_date['updated_at']}}</span><br />
            </div>
        @endisset
        @isset($collect)
            <div>Collections:</div>
            <span class="paint-sync">last sync: {{$update_date === null ? 'app not updated yet' : $update_date['updated_at']}}</span><br />
        @endisset
        @isset($products)
            <div class="sub-headline">Products:</div>
            <span class="paint-sync">last sync: {{$update_date === null ? 'app not updated yet' : $update_date['updated_at']}}</span><br />
        @endisset
        <table >
            <thead>
                <tr>
                @isset($collect)
                    <th>name</th>
                    <th>number of products</th>
                @endisset
                @isset($collection)
                    <th>name</th>
                    <th>status</th>
                @endisset
                @isset($products)
                    <th>name</th>
                    <th>handle</th>
                    <th>status</th>
                    <th>description</th>
                    <th>number of collections</th>
                    <th>max variant compare</th>
                    <th>min variant compare</th>
                @endisset
                </tr>
            </thead>
            @isset($collection)
                <tbody >
            @endisset
            @isset($product)
                <tbody>
            @endisset
            @isset($collect)
                <tbody id="collections_table">
            @endisset
            @isset($products)
                <tbody id="products_table">
            @endisset
            @isset($collect)
                @foreach ($collect as $us1)
                        <tr>
                            <td ><a href="/prdct/{{$us1->id}}">{{ $us1->title }}</a></td>
                            <td>{{ $us1->products->count() }}</td>
                        </tr>
                @endforeach
            @endisset
            @isset($collection)
                @foreach ($collection->products as $product)
                    <tr>
                        <td ><a href="/proddets/{{$product->id}}">{{ $product->title }}</a></td>
                        <td>{{ $product->status }}</td>
                    </tr>
                @endforeach
            @endisset
            @isset($products)
                @foreach ($products as $product)
                    <tr>
                        <td><a href="/proddets/{{$product->id}}">{{$product['title']}}</a></td>
                        <td>{{$product['handle']}}</td>
                        <td>{{$product['status']}}</td>
                        <td>{{$product['description']}}</td>
                        <td>{{$product['num_of_collections']}}</td>
                        <td>{{$product['max_variant_compare']}}</td>
                        <td>{{$product['min_variant_compare']}}</td>
                    </tr>
                @endforeach
            @endisset
            </tbody>
        </tbody>
        @isset($collect)
            <script>
                window.onload = (event) => {
                    if({{$num_of_objs}} <= 50){
                        return;
                    }
                    var ids_check = [];
                    fetch('/collectionsload/{{$batch_size}}', {
                        method: 'get',
                        headers: {
                        'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                        throw new Error('Network response was not ok');
                        }
                        console.log(response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);
                        for(var poiu=0; poiu < data.length; poiu++){
                            if(ids_check.indexOf(data[poiu].id) > -1)
                                continue;
                            ids_check.push(data[poiu].id);
                            var tr_elm = document.createElement('tr');
                            var new_td = document.createElement('td');
                            var new_td1 = document.createElement('td');
                            var new_href = document.createElement('a');
                            new_href.href = "/prdct/"+data[poiu].id;
                            new_href.innerHTML = data[poiu].title;
                            new_td.append(new_href);
                            tr_elm.append(new_td);
                            new_td1.innerHTML = data[poiu].num_of_products;
                            tr_elm.append(new_td1);
                            document.getElementById('collections_table').append(tr_elm);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                };
            </script>
        @endisset
        @isset($products)
            <script>
                window.onload = (event) => {
                    var ids_check = [];
                    if({{$num_of_objs}} <= {{$batch_size}}){
                        return;
                    }
                    fetch('/productsload/{{$batch_size}}', {
                        method: 'get',
                        headers: {
                        'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                        throw new Error('Network response was not ok');
                        }
                        console.log('first response');
                        console.log(response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);
                        for(var poiu=0; poiu < data.length; poiu++){
                            if(ids_check.indexOf(data[poiu].id) > -1)
                                continue;
                            ids_check.push(data[poiu].id);
                            var tr_elm = document.createElement('tr');
                            var new_td = document.createElement('td');
                            var new_href = document.createElement('a');
                            new_href.href = "/proddets/"+data[poiu].id;
                            new_href.innerHTML = data[poiu].title;
                            new_td.append(new_href);
                            tr_elm.append(new_td);
                            var new_td1 = document.createElement('td');
                            new_td1.innerHTML = data[poiu].handle;
                            tr_elm.append(new_td1);
                            var new_td2 = document.createElement('td');
                            new_td2.innerHTML = data[poiu].status;
                            tr_elm.append(new_td2);
                            var new_td3 = document.createElement('td');
                            new_td3.innerHTML = data[poiu].description;
                            tr_elm.append(new_td3);
                            var new_td4 = document.createElement('td');
                            new_td4.innerHTML = data[poiu].num_of_collections;
                            tr_elm.append(new_td4);
                            var new_td5 = document.createElement('td');
                            new_td5.innerHTML = data[poiu].max_variant_compare;
                            tr_elm.append(new_td5);
                            var new_td6 = document.createElement('td');
                            new_td6.innerHTML = data[poiu].min_variant_compare;
                            tr_elm.append(new_td6);
                            document.getElementById('products_table').append(tr_elm);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                };
            </script>
        @endisset
        
    </div>
</div>