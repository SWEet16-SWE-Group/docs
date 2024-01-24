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
      quantita: []
    };
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
  }

  componentDidMount() {
    let id_prenotazione = 0;
    if (localStorage && localStorage.getItem('idp')) { id_prenotazione = JSON.parse(localStorage.getItem('idp')) }

    axios.post("http://localhost:8888/select_prenotazione.php ", { id_prenotazione }).then(response =>
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

  handleNumberChange = (index) => (event) => {
    const { value } = event.target;
    this.setState((prevState) => {
      const updatedQuantita = [...prevState.quantita];
      updatedQuantita[index] = { porzioni: value };
      return { quantita: updatedQuantita };
    });
  };

  handleSubmit = (index) => (event) => {

    event.preventDefault();

    const cliente = JSON.parse(localStorage.getItem('idc'));
    const tavolo = this.state.prenotazione[0].Id_tavolo;
    const ristorante = this.state.prenotazione[0].Id_ristorante;
    const prodotto = this.state.pietanze[index].ID_prodotto;
    const porzioni = this.state.quantita[index] ? this.state.quantita[index].porzioni : 1;
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
            {this.state.pietanze && this.state.pietanze.map((rs, index) => (
            <form key={index} className="card m-5 col-lg-3 col-sm-6" onSubmit={this.handleSubmit(index)}>
                <img className="card-img-top h-50" src ={`data:image/jpeg;base64,${rs.Immagine}`} alt={rs.Nome_Immagine}/>
              <div className="card-body text-center">
                <h5 className="card-title">{rs.Nome}</h5>
                <p className="card-text">{rs.Descrizione}</p>
                <div className="row justify-content-center mb-3">
                  <input type="number" className="form-control w-25 text-center" name={"quantita" + rs.Nome} id={"quantita" + rs.Nome} min="1" defaultValue="1" onChange={this.handleNumberChange(index)}/>
                </div>
                <h6 className="card-text">€{rs.Prezzo}</h6>
              </div>
                <Link to={`/dettaglipietanza/${rs.ID_prodotto}`} className="btn btn-outline-primary btn-outline btn-lg m-2">DETTAGLI</Link>
                <button type="submit" className="btn btn-primary btn-lg m-2">AGGIUNGI</button>
            </form>
            ))}
          </div>
          {this.state.prenotazione.length !== 0 && this.state.prenotazione.map((rs, index) => (
            <div key={index} className="mt-5 d-flex justify-content-center">
                <Link to={`/ordinazioni/${rs.ID_prenotazione}`} className="btn btn-outline-primary btn-outline btn-lg w-100 m-2">TORNA ALLE ORDINAZIONI</Link>
            </div>
          ))}
        </div>
      </>

    );
          
  }
}

export default MenuPietanze;