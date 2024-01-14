import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Login from './components/login';
import Navbar from './components/navbar';
import DashboardClienti from './components/dashboard_clienti';
import DashboardRistoratori from './components/dashboard_ristoratori';
//import FormPrenotazione from './components/form_prenotazione.js';
import './App.css';


function App() {
    return (
    <div className="App">
      <Navbar />
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Login />} />
          <Route path="/login" element={<Login />} />
          <Route path="/dashboardclienti" element={<DashboardClienti />} />
          <Route path="/dashboardristoratori" element={<DashboardRistoratori />} />
          {/*<Route path="/form_prenotazione" element={<FormPrenotazione />} />*/}
        </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;

