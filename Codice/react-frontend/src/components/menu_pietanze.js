import React, { Component } from 'react';
import axios from 'axios';

import Navbar from './navbar';

class MenuPietanze extends Component {
  constructor(props) {
    super(props);
    this.state = {
      prenotazione: [],
      pietanze: [],
    };
  }

  componentDidMount() {
    let id_cliente = 1;
    let utente = "Pasta";
    if (localStorage && localStorage.getItem('idc')) { id_cliente = JSON.parse(localStorage.getItem('idc')) }
    if (localStorage && localStorage.getItem('idu')) { utente = JSON.parse(localStorage.getItem('idu')) }
    const ricerca_ristorante = [
      {
        id_cliente: id_cliente,
        username: utente,
      }
    ]

    axios.post("http://localhost:8888/select_prenotazione_utente.php ", ricerca_ristorante[0]).then(response =>
      this.setState({ prenotazione: response.data }, () => {
        let id_ristorante = this.state.prenotazione[0].Id_ristorante;
        axios.post('http://localhost:8888/select_multiple_prodotto.php', { id_ristorante }).then(response => {
          this.setState({ pietanze: response.data });
        })
      }))
  }

  render() {

    return (
        
      <>
        <Navbar key="navbar-key" />
        <div className="container-fluid p-auto width-95 margin-tb h-auto">
          <div className="row gx-0 d-flex justify-content-center">
            {this.state.pietanze.map((rs, index) => (
            <div key={index} className="card m-5 col-3">
                <img className="card-img-top h-50" src ={`data:image/jpeg;base64,${rs.Immagine}`} alt={rs.Nome_Immagine}/>
              <div className="card-body text-center">
                <h5 className="card-title">{rs.Nome}</h5>
                <p className="card-text">{rs.Descrizione}</p>
                <h6 className="card-text">€{rs.Prezzo}</h6>
              </div>
                <button type="button" className="btn btn-primary btn-lg m-2">DETTAGLI</button>
                <button type="button" className="btn btn-primary btn-lg m-2">AGGIUNGI</button>
            </div>
            ))}
          </div>
        </div>
      </>

    );
          
  }
}

export default MenuPietanze;