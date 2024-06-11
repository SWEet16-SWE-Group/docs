import { Link

 } from "react-router-dom";
export default function RestaurantCard({restaurant}) {
    
    return (
        
        <div class="card" style={{width : '18rem' }}>
        <img class="card-img-top" src="..." alt="Card image cap" />
        <div class="card-body">
          <h5 class="card-title">{restaurant.nome}</h5>
          <p class="card-text">Cucina : {restaurant.cucina.Cucina}</p>
          <p  class="card-text">Orario di apertura : {restaurant.orario}</p>
          <p cass="card-text">Indirizzo : {restaurant.indirizzo}</p>
          <Link to={`/ristorante/${restaurant.nome}`}>
                    Vai alla pagina del ristorante
          </Link>
        </div>
      </div>
    );
}