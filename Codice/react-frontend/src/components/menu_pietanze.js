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
    console.log(this.state);

    return (
        
      <>
        <Navbar key="navbar-key" />
            <div className="card-deck">
            <div className="card">
            {this.state.pietanze.map((rs, index) => (
              <img key={index} className="card-img-top" src = {`data:image/jpeg;base64,${rs.Immagine}`} alt="Card image cap" />
            ))}
              <div className="card-body">
                <h5 className="card-title">Card title</h5>
                <p className="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p className="card-text"><small className="text-muted">Last updated 3 mins ago</small></p>
              </div>
            </div>
            <div className="card">
              <img className="card-img-top" src="..." alt="Card image cap" />
              <div className="card-body">
                <h5 className="card-title">Card title</h5>
                <p className="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                <p className="card-text"><small className="text-muted">Last updated 3 mins ago</small></p>
              </div>
            </div>
            <div className="card">
              <img className="card-img-top" src="..." alt="Card image cap" />
              <div className="card-body">
                <h5 className="card-title">Card title</h5>
                <p className="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                <p className="card-text"><small className="text-muted">Last updated 3 mins ago</small></p>
              </div>
            </div>
          </div>
      </>

    );
          
  }
}

export default MenuPietanze;