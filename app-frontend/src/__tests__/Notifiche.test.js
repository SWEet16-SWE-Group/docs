import React from 'react';
import { fireEvent, render, screen , waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import axiosClient from '../axios-client';
import { act } from 'react';
import Notifiche from '../views/Notifiche';

jest.mock('../axios-client');
jest.mock('../contexts/ContextProvider', () => {
    const originalModule = jest.requireActual('../contexts/ContextProvider');
    return {
        ...originalModule,
        useStateContext: jest.fn(),
    };
});

const renderWithContext = (component) => {
    act(() => {
        render(
            <ContextProvider>
                <MemoryRouter initialEntries={['/dashboardcliente']}>
                    <Routes>
                        <Route path="/dashboardcliente" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('RistoratoreDashboard', () => {
    const clientId = 'client_id';
    const ristorante_id='ristorante_id';
    let mockUseStateContext;

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('Rendering client notifications', async () => {
        mockUseStateContext = {
            profile: clientId,
            role : 'CLIENTE',
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    
        axiosClient.get.mockResolvedValueOnce({
            data : [
                {
                    significato:'PRENOTAZIONE STATO',
                    r_nome:'ristorante_nome',
                    p_id:'prenotazione_id',
                    p_stato:'Accettata',
                    created_at:'2024-06-05 08:15:00'
            },
                {
                    significato:'INVITO ACCETTATO',
                    i_nome:'Tullio',
                    p_id:'prenotazione_id',
                    created_at:'2024-06-03 07:15:00'
            },
        ]
        });
        renderWithContext(<Notifiche/>);

        await waitFor(() => {
            expect(screen.getByText(/Tullio ha accettato l'invito alla/i)).toBeInTheDocument();
            expect(screen.getByText(/ristorante_nome/i)).toBeInTheDocument();
        });
    });

    it('Rendering restaurant notifications', async () => {
        mockUseStateContext = {
            profile: ristorante_id,
            role : 'RISTORATORE',
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    
        axiosClient.get.mockResolvedValueOnce({
            data : [
                {
                    significato:'PRENOTAZIONE CREATA',
                    c_nome:'Tullio',
                    p_id:'prenotazione_id',
                    created_at:'2024-06-25 20:00:00'
            },
                {
                    significato:'PRENOTAZIONE CONTO',
                    p_id:'prenotazione_id',
                    created_at:'2024-06-22 21:15:00'
            },
            {
                significato:'ORDINAZIONE CREATA',
                c_nome:'Tullio',
                p_id:'prenotazione_id',
                pz_nome:'Pizza margherita',
                created_at:'2024-06-10 08:15:00'
        },
        {
            significato:'ORDINAZIONE PAGATA',
            c_nome:'Tullio',
            p_id:'prenotazione_id',
            pz_nome:'Pizza margherita',
            created_at:'2024-06-12 07:15:00'
    }, {
        significato:'INVITO PAGATO',
        c_nome:'Tullio',
        p_id:'prenotazione_id',
        created_at:'2024-06-05 07:15:00'
},
        ]
        });
        renderWithContext(<Notifiche/>);

        await waitFor(() => {
            expect(screen.getByText(/Tullio ha creato una/i)).toBeInTheDocument();
            expect(screen.getByText(/È stata scelto una divisione del conto per la/i)).toBeInTheDocument();
            expect(screen.getByText(/Tullio ha ordinato/i)).toBeInTheDocument();
            expect(screen.getByText(/Tullio ha pagato la sua/i)).toBeInTheDocument();
        });
    });
});