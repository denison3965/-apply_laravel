<h1>One person applied and I send the curriculum</h1>

<h2>Information about the candidate</h2>

<p>
    <p>Name : {{$name}}</p> 
    <p>Email : {{$email}}</p> 
    <p>Phone : {{$phone}}</p> 
    <p>adress : {{$adress}}</p> 
    <p>curriculum_path : {{$curriculum_path}} </p>
    <p>curriculum : <a href={{$curriculum_path}}>download</a></p> 
    <p>ip : {{$ip}}</p>

</p>

<hr/>

Email sent at {{date('d/m/y H:i:s')}}. 