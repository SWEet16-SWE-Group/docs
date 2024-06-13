import { Link } from "react-router-dom";

export default function RestaurantCard({restaurant}) {
    
    return (
      <div class="card" >
        <div class="card-body">
          <h5 class="card-title">{restaurant.nome}</h5>
          <p class="card-text">Cucina : {restaurant.cucina}</p>
          <p  class="card-text">Orario di apertura : {restaurant.orario}</p>
          <p cass="card-text">Indirizzo : {restaurant.indirizzo}</p>
          <Link to={`/ristorante/${restaurant.id}`}>Vai alla pagina del ristorante</Link>
        </div>
      </div>
    );
}
