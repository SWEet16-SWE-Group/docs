import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

import Navbar from './navbar';

class MenuPietanze extends Component {
  constructor(props) {
    super(props);
    this.state = {
      prenotazione: [],
      pietanze: [],
      quantita: 1
    };
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
  }

  componentDidMount() {
    let id_cliente = -1;
    let utente = "";
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
      if(this.state.prenotazione[0]!==null)
      {
        let id_ristorante = this.state.prenotazione[0].Id_ristorante;
        axios.post('http://localhost:8888/select_multiple_prodotto.php', { id_ristorante }).then(response => {
          this.setState({ pietanze: response.data });
        })
      }
      }))
  }

  handleNumberChange = (event) => {
    let numero = event.target.value;
    this.setState({quantita: numero});
  }

  handleSubmit = (index) => (event) => {

    event.preventDefault();

    const cliente = JSON.parse(localStorage.getItem('idc'));
    const tavolo = this.state.prenotazione[0].Id_tavolo;
    const ristorante = this.state.prenotazione[0].Id_ristorante;
    const prodotto = this.state.pietanze[index].ID_prodotto;
    const porzioni = this.state.quantita;
    const tot = this.state.pietanze[index].Prezzo * porzioni;


    const insert = [
      {
        id_cliente: cliente,
        id_tavolo: tavolo,
        id_ristorante: ristorante,
        id_prodotto: prodotto,
        quantita: porzioni,
        totale: tot
      }
    ]

    axios
      .post("http://localhost:8888/insert_ordine.php", insert[0]).then(response => {
        console.log( response.data );
      })

      console.log(insert[0]);
  };

  render() {

    return (
        
      <>
        <Navbar key="navbar-key" />
        {this.state.prenotazione[0]===null && (
          <h1 className="margin-tb text-center">Nessuna prenotazione trovata</h1>
        )}
        <div className="container-fluid p-auto width-95 margin-tb h-auto">
          <div className="row gx-0 d-flex justify-content-center">
            {this.state.pietanze.map((rs, index) => (
            <form key={index} className="card m-5 col-lg-3 col-sm-6" onSubmit={this.handleSubmit(index)}>
                <img className="card-img-top h-50" src ={`data:image/jpeg;base64,${rs.Immagine}`} alt={rs.Nome_Immagine}/>
              <div className="card-body text-center">
                <h5 className="card-title">{rs.Nome}</h5>
                <p className="card-text">{rs.Descrizione}</p>
                <div className="row justify-content-center mb-3">
                  <input type="number" className="form-control w-25 text-center" name={"quantita" + rs.Nome} id={"quantita" + rs.Nome} min="1" defaultValue="1" onChange={this.handleNumberChange}/>
                </div>
                <h6 className="card-text">€{rs.Prezzo}</h6>
              </div>
                <Link to={`/dettagli/${rs.ID_prodotto}`} className="btn btn-outline-primary btn-outline btn-lg m-2">DETTAGLI</Link>
                <button type="submit" className="btn btn-primary btn-lg m-2">AGGIUNGI</button>
            </form>
            ))}
          </div>
        </div>
      </>

    );
          
  }
}

export default MenuPietanze;