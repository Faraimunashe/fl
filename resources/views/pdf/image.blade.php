<style>
    /* ID Card */
.id-card {
    width: 560px;
    height: 240px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
}

/* ID Card Header */
.id-card-header {
    background-color: #13301b;
    color: #fff;
    padding: 10px;
    display: flex;
    align-items: center;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.id-card-header img {
    width: 40px;
    height: 40px;
    margin-right: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.id-card-header h1 {
    font-size: 20px;
    margin: 0;
}

/* ID Card Body */
.id-card-body {
    display: flex;
    padding: 20px;
}

.personal-info {
    display: flex;
    align-items: center;
}

.photo {
    width: 120px;
    height: 100px;
    margin-right: 20px;
    overflow: hidden;
    border: 1px solid #ccc;
}

.photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.personal-details h2 {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
    color: #444;
}

.personal-details p {
    margin: 5px 0 0 0;
    font-size: 14px;
    color: #666;
}

.id-info {
    margin-left: auto;
}

.id-info ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.id-info li {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
    color: #666;
}

.id-info li span:first-child {
    font-weight: bold;
    margin-right: 10px;
}

/* Responsive Design */
@media (max-width: 480px) {
    .id-card {
    width: 100%;
    height: auto;
    border-radius: 0;
    }

    .id-card-body {
    flex-direction: column;
    padding: 10px;
    }

    .personal-info {
    margin-bottom: 10px;
    }

    .photo {
    width: 80px;
    height: 100px;
    margin-right: 0;
    margin-bottom: 10px;
    }

    .personal-details h2 {
    font-size: 20px;
    }

    .id-info {
    margin-left: 0;
    margin-top: 10px;
    }

    .id-info li {
    font-size: 12px;
    }
}

</style>
<div class="id-card">
<div class="id-card-header">
  <img src="{{asset('images/parks.png')}}" alt="National ID Logo">
  <h1>Zimbabwe National Parks Wildlife Permit</h1>
</div>
<div class="id-card-body">
  <div class="personal-info">
    <div class="photo">
      <img src="{{asset('images')}}/{{$img->image}}" alt="Photo">
    </div>
    <div class="personal-details">
      <h2>{{$account->fname}} {{$account->lname}}</h2>
      <p>{{$account->natid}}</p>
      <p>{{$account->sex}}</p>
      <p>{{$account->address}}</p>
    </div>
  </div>
  <div class="id-info">
    <ul>
      <li>
        <span>ID #:</span>
        <span>{{$permit->reference}}</span>
      </li>
      <li>
        <span>Expiration:</span>
        <span>{{$permit->expiry_date}}</span>
      </li>
      <li>
        <span>Authority:</span>
        <span>ZIMPARKS</span>
      </li>
    </ul>
  </div>
</div>
</div>
