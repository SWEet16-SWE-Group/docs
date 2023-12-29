import React, { Component } from 'react';
import { Carousel } from 'react-bootstrap';
import axios from 'axios';

class FormPrenotazione extends Component {
  constructor(props) {
    super(props);
    this.state = {
      ristoranti: [],
      ristorantifiltrati: [],
      ristoranteselezionato: [],
      tavoli: [],
      orari: [],
      cerca: "",
      numeropersone: "",
      data: "",
      orarioarrivo: "",
      orariopartenza: "",
      fascia: "",
      page: 0,
      page0compiled: false,
      page1compiled: false,
      page2compiled: false,
      page3compiled: false,
      page4compiled: false,
    };
    this.filterList = this.filterList.bind(this);
    this.handleSearch = this.handleSearch.bind(this);
    this.handleRadioChange = this.handleRadioChange.bind(this);
    this.handleRadio2Change = this.handleRadio2Change.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
    this.handleDateChange = this.handleDateChange.bind(this);
    this.handleTimeAClick = this.handleTimeAClick.bind(this);
    this.handleTimePClick = this.handleTimePClick.bind(this);
  }

  componentDidMount() {
    axios.get('http://localhost:8888/select_multiple_ristorante.php').then(response =>
      this.setState({ ristoranti: response.data}));
  }

  handleSelect = (selectedPage) => {
    this.setState({ page: selectedPage });
  };

  handleSearch = (event) => {
    const cerca = event.target.value.toLowerCase();
    this.setState({ cerca }, () => this.filterList());
  }

  filterList() {
    let ristoranti = this.state.ristoranti;
    let cerca = this.state.cerca;

    ristoranti = ristoranti.filter(function(ristoranti) {
      return ristoranti.Ragione_sociale.toLowerCase().indexOf(cerca) !== -1;
    });
    this.setState({ ristorantifiltrati: ristoranti });
  }

  handleRadioChange = (event) => { 
    let id = event.target.value;
    this.state.ristoranteselezionato[0] = this.state.ristoranti[id];
    this.state.page0compiled = true;
    document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
  }

  handleDateChange = (event) => { 
    let data = event.target.value;
    this.state.data = data;
    if(this.state.fascia !== "") 
    {
      this.state.page1compiled=true;
      document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
    }
    else
    {
      this.state.page1compiled=false;
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
    }
  }

  handleRadio2Change = (event) => { 
    this.setState({fascia: event.target.value});
    if(this.state.data !== "") 
    {
      this.state.page1compiled=true;
      document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
    }
    else
    {
      this.state.page1compiled=false;
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
    }
  }


  handleTimeAClick = (event) => { 
    let oraa = event.target.value;
    this.state.orarioarrivo = oraa;
    if(oraa !== "")
    {
      this.state.page3compiled=true;
      document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
    }
    else
    {
      this.state.page3compiled=false;
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
    }
  }

  handleTimePClick = (event) => { 
    let orap = event.target.value;
    this.state.orariopartenza = orap;
    if(orap !== "")
    {
      this.state.page4compiled=true;
      document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
    }
    else
    {
      this.state.page4compiled=false;
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
    }
  }


  handleNumberChange = (event) => {
    let num = event.target.value;
    if(num==="")
    {
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
      this.state.page2compiled = false;
    }
    else
    {
      this.state.numeropersone = num;
      document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
      this.state.page2compiled = true;
      
      const id =  this.state.ristoranteselezionato[0].ID_ristorante;
      const data =  this.state.data;

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
      
        
        while((a.getHours()<=c.getHours()))
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
        
        while((a.getHours()<=c.getHours()))
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

    const tavolo = [
      {
      id_ristorante : id,
      num_posti : num,
      giorno : data
      } 
    ]
    event.preventDefault();
    
     axios
      .post("http://localhost:8888/select_multiple_tavolo.php", tavolo[0])
      .then(response => {
        this.setState({ tavoli: response.data});

    })       
    }
  }

  compareAllOrari = (orario, index) => {
    const { tavoli } = this.state;

      const tavoliValues = tavoli.map((tavolo) => ({
        tavoloArrivo: tavolo.Orario_arrivo,
        tavoloPartenza: tavolo.Orario_partenza,
        isBetween: this.checkTimeOverlap(tavolo.Orario_arrivo, tavolo.Orario_partenza, orario)
      }))
      const ok = tavoliValues.every((tavolo) => tavolo.isBetween);
      
      if(ok===false)
      {
        if((index+1)%4==0)
        {
          return (
            <>
            <span key={index} className="form-group">
              <input type="button" className="btn btn-outline-primary m-2" value={orario} onClick={this.handleTimeAClick}/>
            </span>
            <br /><br />
            </>
          )
        }
        else
        {
          return (
            <span key={index} className="form-group">
              <input type="button" className="btn btn-outline-primary m-2" value={orario} onClick={this.handleTimeAClick}/>
            </span>
          )
        }
      }
      else
      {
        if((index+1)%4==0)
        {
          return (
            <>
            <span key={index} className="form-group">
              <button type="submit" className="btn btn-outline-secondary m-2" value={orario} disabled>{orario}</button>
            </span>
            <br /><br />
            </>
          )
        }
        else
        {
          return (
            <span key={index} className="form-group">
              <button type="submit" className="btn btn-outline-secondary m-2" disabled>{orario}</button>
            </span>
          )
        }
    }
  };


  checkTimeOverlap = (arrivo, partenza, orario) => {
    const arrivoTime = new Date(`2000-01-01 ${arrivo}`);
    const partenzaTime = new Date(`2000-01-01 ${partenza}`);
    const orarioTime = new Date(`2000-01-01 ${orario}`);

    return orarioTime >= arrivoTime && orarioTime <= partenzaTime;   
  };

  render() {
    const { page } = this.state;

      if(document.getElementsByClassName("carousel-control-prev")[0] && document.getElementsByClassName("carousel-control-next")[0])
      {
        if(page === 0 && this.state.page0compiled === false)
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="none";
          document.getElementsByClassName("carousel-control-next")[0].style.display="none";
        }
        else if(page === 0 && this.state.page0compiled === true) 
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="none";
          document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
        }
        else if((page === 1 && this.state.page1compiled === false) 
              || (page === 2 && this.state.page2compiled === false)
              || (page === 3 && this.state.page3compiled === false)
              || (page === 4 && this.state.page4compiled === false))
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="flex";
          document.getElementsByClassName("carousel-control-next")[0].style.display="none";
        }
        else if((page === 1 && this.state.page1compiled === true) 
              || (page === 2 && this.state.page2compiled === true)
              || (page === 3 && this.state.page3compiled === true)
              || (page === 4 && this.state.page4compiled === true))
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="flex";
          document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
        }
        else if(page === 5)
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="flex";
          document.getElementsByClassName("carousel-control-next")[0].style.display="none";
        }
    }
    return (
        <form>
        <Carousel activeIndex={page} onSelect={this.handleSelect} className="container-fluid p-auto w-75 border rounded border-2 margin-top h-auto" autoPlay={false} interval={null} controls={true} indicators={false}>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div className="m-5">
                              <label htmlFor="ricerca">Trova un ristorante:</label>
                              <input type="text" className="form-control mb-3" name="ricerca" id="ricerca" placeholder="Cerca" value={this.state.cerca} onChange={this.handleSearch}/>
                              {this.state.ristorantifiltrati.map((rs, index) => (
                              <div key={index}>
                                <input type="radio" className="mb-2 mr-1" id="seleziona_rist" name="seleziona_rist" value={index} onClick={this.handleRadioChange}/> <label htmlFor={rs.Ragione_sociale + "_seleziona"}>{rs.Ragione_sociale}</label>
                              </div>
                              ))}
                            </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div>
                                <div className="m-5">
                                <label htmlFor="data_prenotazione">Seleziona il giorno:</label>
                                <input type="date" className="form-control" name="data_prenotazione" id="data_prenotazione" onChange={this.handleDateChange} />
                                </div>
                                <div className="m-5">
                                <label htmlFor="fascia">Seleziona una fascia oraria:</label>
                                {this.state.ristoranteselezionato.map((rs, index) => (
                                  <div key={index}>
                                    <div>
                                      <input type="radio" className="mb-2 mr-1" id="fascia" name="fascia" value="pranzo" onClick={this.handleRadio2Change}/> <span>Pranzo ({rs.Orario_apertura_mat} - {rs.Orario_chiusura_mat})</span>
                                    </div>
                                    <div>
                                      <input type="radio" className="mb-2 mr-1" id="fascia" name="fascia" value="cena" onClick={this.handleRadio2Change}/> <span>Cena ({rs.Orario_apertura_pom} - {rs.Orario_chiusura_pom})</span>
                                    </div>
                                  </div>
                                ))}
                                </div>
                              </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div className="m-5">
                              <label htmlFor="num_persone">Seleziona il numero di persone:</label>
                              <input type="number" className="form-control" name="num_persone" id="num_persone" min="1" onChange={this.handleNumberChange} />
                            </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                <div className="container-fluid my-4 text-center">
                  {this.state.orari.map((rs, index) => (
                      <>
                          {this.compareAllOrari(rs, index)}
                      </>
                  ))}
                </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                <div className="container-fluid my-4 text-center">
                  {this.state.orari.map((rs, index) => (
                      <>
                          {this.compareAllOrari(rs, index)}
                      </>
                  ))}
                </div>
          </Carousel.Item>
          </Carousel>
        </form>
      );
    }
}
    
export default FormPrenotazione;