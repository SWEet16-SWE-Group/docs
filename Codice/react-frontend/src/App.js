import { Route, Routes } from 'react-router-dom';
import './App.css';

import Navbar from './components/navbar.js';
import FormPrenotazione from './components/form_prenotazione.js';
import DashboardCliente from './components/dashboard_cliente.js';
import Login from './components/login.js';

function App() {
  return (
    <>
      <Navbar />
      <Routes>
        <Route path="/form_prenotazione" element={<FormPrenotazione />} />
        <Route path="/dashboard_cliente" element={<DashboardCliente />} />
        <Route path="/login" element={<Login />} />
      </Routes>
    </>
  );
}

export default App;
