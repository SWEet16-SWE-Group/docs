import { Link } from "react-router-dom";

export default function RestaurantCard({restaurant}) {
    
    return (
      <div    className="card" >
        <div  className="card-body">
          <h5 className="card-title">{restaurant.nome}</h5>
          <p  className="card-text">Cucina : {restaurant.cucina}</p>
          <p  className="card-text">Orario di apertura : {restaurant.orario}</p>
          <p  className="card-text">Indirizzo : {restaurant.indirizzo}</p>
          <Link to={`/ristorante/${restaurant.id}`}>Vai alla pagina del ristorante</Link>
        </div>
      </div>
    );
}
