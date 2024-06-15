import React from 'react';
import { fireEvent, render, screen , waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import DashBoardCliente from '../views/DashboardCliente';
import axiosClient from '../axios-client';
import { act } from 'react';

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
    const clientId = '12345';
    let mockUseStateContext;

    beforeEach(() => {
        mockUseStateContext = {
            profile: clientId,
            setNotificationStatus : jest.fn(),
            setNotification : jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        jest.clearAllMocks();
    });
        
    it('Fetching reservations goes well', async () => {
        axiosClient.get.mockResolvedValueOnce({
            data : [
                {
                    id : '123',
                    orario : '20:00',
                    nome : 'Da Luigi',
                    numero_inviti : '6',
                    stato : 'Accettata',
                }
            ]
        });

        renderWithContext(<DashBoardCliente/>);
        expect(axiosClient.get).toHaveBeenCalledWith('/dashboard_c/12345');
        await waitFor( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
        });
    });

    it('Fetching Link invitation goes well', async () => {
        axiosClient.get.mockResolvedValueOnce({
            data : [
                {
                    id : '123',
                    orario : '20:00',
                    nome : 'Da Luigi',
                    numero_inviti : '6',
                    stato : 'Accettata',
                }
            ]
        });

        renderWithContext(<DashBoardCliente/>);
        expect(axiosClient.get).toHaveBeenCalledWith('/dashboard_c/12345');
        await waitFor( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
        });
        
        jest.clearAllMocks();
        const LinkValidation = axiosClient.get.mockResolvedValueOnce({
            data:
                {
                    id:'1',
                }
            });
        act(() => {
            fireEvent.change(screen.getByPlaceholderText(/Codice Invito/i),{target:{value:'12345'}});
            fireEvent.click(screen.getByText(/Invia/i));
        });
        expect(LinkValidation).toHaveBeenCalledWith('/prenotazione_dettagli/12345');
    });

    it('Fetching Link invitation goes wrong', async () => {
        axiosClient.get.mockResolvedValueOnce({
            data : [
                {
                    id : '123',
                    orario : '20:00',
                    nome : 'Da Luigi',
                    numero_inviti : '6',
                    stato : 'Accettata',
                }
            ]
        });

        renderWithContext(<DashBoardCliente/>);
        expect(axiosClient.get).toHaveBeenCalledWith('/dashboard_c/12345');
        await waitFor( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
        });
        
        jest.clearAllMocks();
        const LinkValidation = axiosClient.get.mockResolvedValueOnce({
            data:
                {}
            });
        act(() => {
            fireEvent.change(screen.getByPlaceholderText(/Codice Invito/i),{target:{value:'12345'}});
            fireEvent.click(screen.getByText(/Invia/i));
        });
        expect(LinkValidation).toHaveBeenCalledWith('/prenotazione_dettagli/12345');

        await waitFor(() => {
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Questo codice di invito non esiste!');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('failure');
        });
    });
});