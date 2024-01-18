import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

import Navbar from './navbar';

class DettagliPietanza extends Component {
  constructor(props) {
    super(props);
    this.state = {
        pietanza: [],
        ingredienti: []
    };
   }

   componentDidMount() {
    let pathname = window.location.pathname;
    let id_prodotto = pathname.split('/')[2];
    axios.post('http://localhost:8888/select_single_prodotto.php', { id_prodotto }).then(response => {
        const ingredientiArray=response.data[0].Ingredienti.split(',').map(ingrediente => ingrediente.trim())
        this.setState({ pietanza: response.data, ingredienti: ingredientiArray });
    })
  }

  render() {

    return (
      <>
        <Navbar key="navbar-key" />
        <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb h-auto">
        <form className="row gx-0 d-flex justify-content-center" onSubmit={this.handleSubmit}>
            {this.state.pietanza.map((rs, index) => (
            <div key={index} className="px-0">
                <img className="card-img-top h-50" src ={`data:image/jpeg;base64,${rs.Immagine}`} alt={rs.Nome_Immagine}/>
              <div className="text-center mt-5">
                <h5 className="card-title">{rs.Nome}</h5>
                <p className="card-text">{rs.Descrizione}</p>
                <div className="row justify-content-center mb-3">
                <label htmlFor="ricerca_cliente">Ingredienti presenti:</label>
                {this.state.ingredienti && this.state.ingredienti.map((rs, index) => (
                  <div key={index}>
                    <input type="checkbox" className="form-check-input mb-2 mr-1" id="Ingredienti" name="Ingredienti" value={rs} checked/> <label htmlFor="ingredienti" className="text-break">{rs}</label>
                  </div>
                ))}
                </div>
                <h6 className="card-text">€{rs.Prezzo}</h6>
              </div>
              <div className="d-flex justify-content-center">
                <Link to={`/ordinazione`} className="btn btn-outline-primary btn-outline btn-lg m-2">INDIETRO</Link>
              </div>
            </div>
            ))}
          </form>
        </div>
      </>
    );
  }
}

export default DettagliPietanza;