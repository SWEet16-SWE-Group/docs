import React, { Component } from 'react';
import axios from 'axios';

class FormPrenotazione extends Component {
  constructor(props) {
    super(props);
    this.state = {
      prenotazione: [],
      altriclienti: [],
      clientifiltrati: [],
      clienteselezionato: [],
      ristoranti: [],
      ristorantifiltrati: [],
      ristoranteselezionato: [],
      tavoli: [],
      tavoloselezionato: [],
      orari: [],
      cerca: "",
      cerca2: "",
      numeropersone: "",
      data: "",
      orarioarrivo: "",
      orariopartenza: "",
      fascia: "",
      form: true,
      invito: false,
      orarioArrivoSelezionato: false,
    };
    this.filterList = this.filterList.bind(this);
    this.filterList2 = this.filterList2.bind(this);
    this.handleSearch = this.handleSearch.bind(this);
    this.handleSearch2 = this.handleSearch2.bind(this);
    this.handleRadioChange = this.handleRadioChange.bind(this);
    this.handleRadio2Change = this.handleRadio2Change.bind(this);
    this.FasciaChange = this.FasciaChange.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
    this.handleDateChange = this.handleDateChange.bind(this);
    this.handleTimeAClick = this.handleTimeAClick.bind(this);
    this.handleTimePClick = this.handleTimePClick.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleInviteClick = this.handleInviteClick.bind(this);
  }

  componentDidMount() {
    axios.get('http://localhost:8888/select_multiple_ristorante.php').then(response =>
      this.setState({ ristoranti: response.data}));

    axios.get('http://localhost:8888/select_single_cliente.php').then(response =>
      this.setState({ clienteselezionato: response.data}));
  }

  componentSendData(){
    if((this.state.numeropersone !== "") && (this.state.ristoranteselezionato[0].ID_ristorante !== "") && (this.state.data !== ""))
    {
    const tavolo = [
      {
      id_ristorante : this.state.ristoranteselezionato[0].ID_ristorante,
      num_posti : this.state.numeropersone,
      giorno : this.state.data
      } 
    ]

     axios
      .post("http://localhost:8888/select_multiple_tavolo.php", tavolo[0]).then(response => 
      {
        this.setState({ tavoli: response.data});
      }) 
    }

  }


  handleSearch = (event) => {
    const cerca = event.target.value.toLowerCase();
    this.setState({ cerca }, () => this.filterList());
  }

  filterList() {
    let ristoranti = this.state.ristoranti;
    let cerca = this.state.cerca;

    ristoranti = ristoranti.filter(function(ristoranti) {
        return cerca!=="" && ristoranti.Ragione_sociale.toLowerCase().indexOf(cerca) !== -1;
    });
    this.setState({ ristorantifiltrati: ristoranti });
  }

  handleRadioChange = (event) => { 
    let id = event.target.value;
    const nuovoRistoranteSelezionato = [this.state.ristoranti[id]];

    this.setState({ristoranteselezionato: nuovoRistoranteSelezionato,});
  }

  handleSearch2 = (event) => {
    const cerca2 = event.target.value.toLowerCase();
    this.setState({ cerca2 }, () => this.filterList2());
  }

  filterList2() {
    let clienti = this.state.altriclienti;
    let cerca2 = this.state.cerca2;

    clienti = clienti.filter(function(clienti) {
        return cerca2!=="" && clienti.Username.toLowerCase().indexOf(cerca2) !== -1;
    });
    this.setState({ clientifiltrati: clienti });
  }

  handleDateChange = (event) => { 
    this.setState({data: event.target.value });

  }

  handleRadio2Change = (event) => { 
    this.setState({ fascia: event.target.value }, () => {
        this.FasciaChange();
    });
  }


  handleTimeAClick = (event) => { 
    this.setState({orarioarrivo: event.target.value, orarioArrivoSelezionato: true, orariopartenza: "" });
    let id = event.target.id;
    if(document.getElementsByClassName("partenza")[0])
    {
      document.getElementsByClassName("partenza")[0].classList.remove("active");
      document.getElementsByClassName("partenza")[0].classList.remove("partenza");
    }
    if(document.getElementsByClassName("arrivo")[0])
    {
        document.getElementsByClassName("arrivo")[0].classList.remove("active");
        document.getElementsByClassName("arrivo")[0].classList.remove("arrivo");
    }
      document.getElementById(id).classList.add("active");
      document.getElementById(id).classList.add("arrivo");
  }

  handleTimePClick = (event) => { 
    this.setState({orariopartenza: event.target.value });
    let id = event.target.id;
    if(document.getElementsByClassName("partenza")[0])
    {
      document.getElementsByClassName("partenza")[0].classList.remove("active");
      document.getElementsByClassName("partenza")[0].classList.remove("partenza");
    }
    document.getElementById(id).classList.add("active");
    document.getElementById(id).classList.add("partenza");
  }

  FasciaChange()
  {
    this.state.orari.length=0;
    if(this.state.fascia==="pranzo")
    {
      let apertura = this.state.ristoranteselezionato[0].Orario_apertura_mat;
      let chiusura = this.state.ristoranteselezionato[0].Orario_chiusura_mat;

      let aperturaParts = apertura.split(":");    
      let chiusuraParts = chiusura.split(":");  

      let a = new Date();
      let c = new Date();

      a.setHours(+aperturaParts[0]);    
      a.setMinutes(+aperturaParts[1]); 

      c.setHours(+chiusuraParts[0]);    
      c.setMinutes(+chiusuraParts[1]);
    
      
      while((a.getHours()!==c.getHours()))
      {
        let item=a.getHours() + ":" + (a.getMinutes() === 0 ? "00" : a.getMinutes());
        this.state.orari.push(item);
        a.setMinutes(a.getMinutes()+15);
      }
      while((a.getMinutes()<=c.getMinutes()))
      {
        let item=a.getHours() + ":" + (a.getMinutes() === 0 ? "00" : a.getMinutes());
        this.state.orari.push(item);
        a.setMinutes(a.getMinutes()+15,0,0);
      }
    }
    else if(this.state.fascia==="cena")
    {
      let apertura = this.state.ristoranteselezionato[0].Orario_apertura_pom;
      let chiusura = this.state.ristoranteselezionato[0].Orario_chiusura_pom;

      let aperturaParts = apertura.split(":");    
      let chiusuraParts = chiusura.split(":");  

      let a = new Date();
      let c = new Date();

      a.setHours(+aperturaParts[0]);    
      a.setMinutes(+aperturaParts[1]); 

      c.setHours(+chiusuraParts[0]);    
      c.setMinutes(+chiusuraParts[1]);
      
      while((a.getHours()!==c.getHours()))
      {
        let item=a.getHours() + ":" + (a.getMinutes() === 0 ? "00" : a.getMinutes());
        this.state.orari.push(item);
        a.setMinutes(a.getMinutes()+15);
      }
      while((a.getMinutes()<=c.getMinutes()))
      {
        let item=a.getHours() + ":" + (a.getMinutes() === 0 ? "00" : a.getMinutes());
        this.state.orari.push(item);
        a.setMinutes(a.getMinutes()+15,0,0);
      }
    }
  }

  handleNumberChange = (event) => {
    this.setState({numeropersone: event.target.value}, () => {
        event.preventDefault();

        this.componentSendData();
    }); 
  }

  compareAllOrari = (orario, index) => {
    const { tavoli } = this.state;

        const tavoloValido = tavoli.find((tavolo) => tavolo.Data_prenotazione === null);
        if(tavoloValido)
        {
          const TavoloValido = tavoli[tavoli.indexOf(tavoloValido)];
          this.state.tavoloselezionato[0] = TavoloValido;
        }
        if(index+1===this.state.orari.length)
        {
          return;
        }
        else
        {         
          if((index+1)%4 === 0)
          {
            return (
              <>
                <input id={"arrivo"+index} name={"arrivo"+index} type="button" className="btn btn-outline-primary m-2" value={orario} onClick={this.handleTimeAClick}/>
                <br />
              </>
            )
          }
          else
          {
            return <input id={"arrivo"+index} name={"arrivo"+index} type="button" className="btn btn-outline-primary m-2" value={orario} onClick={this.handleTimeAClick}/>
          }
        }
  };

  checkTimeOverlap = (arrivo, partenza, orario) => {

    const arrivoTime = new Date(`2000-01-01 ${arrivo}`);
    const partenzaTime = new Date(`2000-01-01 ${partenza}`);
    const orarioTime = new Date(`2000-01-01 ${orario}`);

    return orarioTime >= arrivoTime && orarioTime <= partenzaTime;   
  };

  compareAfterOrari = (orario, index) => {
    const { orarioarrivo } = this.state;

      const ok = this.checkTimeAfter(orarioarrivo, orario);

      if(ok===false)
      { 
        if(index===0)
        {
          return;
        }
        else
        {        
          if((index)%4 === 0)
          {
            return (
              <>
                <input id={"partenza"+index} name={"partenza"+index} type="button" className="btn btn-outline-primary m-2" value={orario} onClick={this.handleTimePClick}/>
                <br />
              </>
            )
          }
          else
          {
            return <input id={"partenza"+index} name={"partenza"+index} type="button" className="btn btn-outline-primary m-2" value={orario} onClick={this.handleTimePClick}/>
          }
        }
      }
      else
      {
        if(index===0)
        {
          return;
        }
        else
        {        
          if((index)%4 === 0)
          {
            return (
              <>
                <input id={"partenza"+index} name={"partenza"+index} type="button" className="btn btn-outline-secondary m-2" value={orario} disabled onClick={this.handleTimePClick}/>
                <br />
              </>
            )
          }
          else
          {
            return <input id={"partenza"+index} name={"partenza"+index} type="button" className="btn btn-outline-secondary m-2" value={orario} disabled onClick={this.handleTimePClick}/>
          }
        }
    }
  };
  
  checkTimeAfter = (arrivo, orario) => {
    const arrivoTime = new Date(`2000-01-01 ${arrivo}`);
    const orarioTime = new Date(`2000-01-01 ${orario}`);

    return orarioTime <= arrivoTime;   
  };
  

  handleSubmit = (event) => {
    event.preventDefault();

    const cliente = this.state.clienteselezionato[0].ID_cliente;
    const tavolo = this.state.tavoloselezionato[0].ID_tavolo;
    const ristorante = this.state.ristoranteselezionato[0].ID_ristorante;
    const numero = this.state.numeropersone;
    const username = this.state.clienteselezionato[0].Username;
    const codice = username + "#" + tavolo;
    const data = this.state.data;
    const inizio = this.state.orarioarrivo;
    const fine = this.state.orariopartenza;
    const cod_tavolo = this.state.tavoloselezionato[0].Codice;
    const posti_tavolo = this.state.tavoloselezionato[0].Num_posti;

    const insert = [
      {
      id_cliente : cliente,
      id_tavolo : tavolo,
      id_ristorante : ristorante,
      codice_prenotazione: codice,
      numero_persone : numero,
      partecipanti : username,
      giorno : data,
      arrivo: inizio,
      partenza: fine,
      codice: cod_tavolo,
      posti: posti_tavolo
      }
    ]

    axios
      .post("http://localhost:8888/insert_prenotazione.php", insert[0]).then(response => 
      {
        this.setState({ prenotazione: response.data});
      })
    
    let id_cliente=this.state.clienteselezionato[0].ID_cliente;
    axios.post('http://localhost:8888/select_multiple_exeption_cliente.php', {id_cliente}).then(response =>
    {        
      this.setState({ altriclienti: response.data});
    }) 

    this.setState({form: false, invito: true});

  };

  handleInviteClick = (index) => (event) => { 
    let nome = event.target.value;
    let lista = this.state.prenotazione[0].Partecipanti + "," + nome;
    let id_prenotazione=this.state.prenotazione[0].ID_prenotazione;
    axios.post('http://localhost:8888/update_prenotazione.php', {id_prenotazione, lista})
    document.getElementById("invito" + index).setAttribute("disabled","disabled");
    document.getElementById("invito" + index).innerHTML = 'Invitato';

    const reducedArr = [...this.state.altriclienti];
    reducedArr.splice(index, 1);
    this.setState({altriclienti: reducedArr})

  }


  render() {

    return (
        <>
        {this.state.form && (
        <form id="form-prenotazione" className="container-fluid p-auto w-75 border rounded border-2 margin-tb h-auto" onSubmit={this.handleSubmit}>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
            <div className="m-5">
                <label htmlFor="ricerca">Trova un ristorante:</label>
                <input type="text" className="form-control mb-3" name="ricerca_rist" id="ricerca_rist" placeholder="Cerca" value={this.state.cerca} onChange={this.handleSearch}/>
                {this.state.ristorantifiltrati.map((rs, index) => (
                    <div key={index}>
                        <input type="radio" className="form-check-input mb-2 mr-1" id="seleziona_rist" name="seleziona_rist" value={index} onClick={this.handleRadioChange}/> <label htmlFor="seleziona_rist" className="text-break">{rs.Ragione_sociale + ", " + rs.Citta}</label>
                    </div>
                ))}
            </div>
            {this.state.ristoranteselezionato[0] && (
            <div>
                <div className="m-5">
                    <label htmlFor="data_prenotazione">Seleziona il giorno:</label>
                    <input type="date" className="form-control" name="data_prenotazione" id="data_prenotazione" onChange={this.handleDateChange} />
                </div>
                <div className="m-5">       
                {this.state.ristoranteselezionato.map((rs, index) => (
                    <div key={index}>
                        <label htmlFor="fascia">Seleziona una fascia oraria:</label>
                        <div>
                            <input type="radio" className="form-check-input mb-2 mr-1" id="fascia" name="fascia" value="pranzo" onClick={this.handleRadio2Change}/> <span>Pranzo ({rs.Orario_apertura_mat} - {rs.Orario_chiusura_mat})</span>
                        </div>
                        <div>
                            <input type="radio" className="form-check-input mb-2 mr-1" id="fascia" name="fascia" value="cena" onClick={this.handleRadio2Change}/> <span>Cena ({rs.Orario_apertura_pom} - {rs.Orario_chiusura_pom})</span>
                        </div>
                    </div>
                ))}
                </div>
            </div>
            )}
            {this.state.data && this.state.fascia && (
            <div className="m-5">
                <label htmlFor="num_persone">Seleziona il numero di persone:</label>
                <input type="number" className="form-control" name="num_persone" id="num_persone" min="1" onChange={this.handleNumberChange} />
            </div>
            )}
            {this.state.numeropersone && (
            <div className="container-fluid my-4 text-center">
                <h3 className="my-4">Seleziona l'orario di arrivo</h3>
                  {this.state.orari.map((rs, index) => (
                      <span key={index} className="form-group">
                          {this.compareAllOrari(rs, index)}
                      </span>
                  ))}
            </div>
            )}
            {this.state.orarioArrivoSelezionato && (
            <div className="container-fluid my-4 text-center">
                <h3 className="my-4">Seleziona l'orario di partenza</h3>
                  {this.state.orari.map((rs, index) => (
                      <span key={index} className="form-group">
                          {this.state.orarioArrivoSelezionato && this.compareAfterOrari(rs, index)}
                      </span>
                  ))}
            </div>
            )}
            {this.state.orariopartenza && (
            <div className="container-fluid my-4 text-center">
                  <h3 className="my-4">Informazioni prenotazione</h3>
                  {this.state.ristoranteselezionato.map((rs, index) => (
                  <h5 key={index} className="my-2">Ristorante: {rs.Ragione_sociale}, {rs.Indirizzo}, {rs.CAP} {rs.Citta} </h5>
                  ))}
                  <h5 className="my-3">Data: {this.state.data}</h5>
                  <h5 className="my-3">Orari: {this.state.orarioarrivo} - {this.state.orariopartenza}</h5>
                  <h5 className="my-3">Numero di persone: {this.state.numeropersone}</h5>
                  {this.state.tavoloselezionato.map((rs, index) => (
                  <h5 key={index} className="my-2">Codice tavolo: {rs.Codice}</h5>
                  ))}
                  <button type="submit" className="btn btn-primary btn-lg w-100 mt-3">PRENOTA</button>
            </div>
            )}
        </form>
        )}

      {this.state.invito && (
        <div id="form-invito">
           <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb h-auto">
           <h1 className="my-4 text-center text-success">PRENOTAZIONE EFFETTUATA CON SUCCESSO</h1>
           {this.state.prenotazione.map((rs, index) => (
              <h5 key={index} className="my-2 text-center">Il tuo codice di prenotazione è: {rs.Codice}</h5>
            ))}
            <div className="m-5">
              <label htmlFor="ricerca_cliente">Invita un altro utente a partecipare:</label>
              <input type="text" className="form-control mb-3" name="ricerca_cliente" id="ricerca_cliente" placeholder="Cerca" value={this.state.cerca2} onChange={this.handleSearch2}/>
              {this.state.clientifiltrati.map((rs, index) => (
                <div key={index}>
                  <button id={"invito"+index} name={"invito"+index} type="button" className="btn btn-outline-primary m-2" value={rs.Username} onClick={this.handleInviteClick(index)}>Invita</button> <label htmlFor={"invito"+index} className="text-break">{rs.Username}</label>
                </div>
              ))}
            </div>
           </div>
        </div>
        )}
      </>
      );
    }
}
    
export default FormPrenotazione;