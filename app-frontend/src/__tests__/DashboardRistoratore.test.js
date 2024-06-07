import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import RistoratoreDashboard from '../views/DashboardRistoratore.jsx';
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
                <MemoryRouter initialEntries={['/dashboardristoratore']}>
                    <Routes>
                        <Route path="/dashboardristoratore" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('RistoratoreDashboard', () => {
    const ristoratoreId = '12345';
    let mockUseStateContext;

    beforeEach(() => {
        localStorage.setItem('RISTORATORE_ID', ristoratoreId);
        axiosClient.get.mockReset();
        axiosClient.put.mockReset();

        mockUseStateContext = {
            profile: ristoratoreId,
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        localStorage.removeItem('RISTORATORE_ID');
        jest.clearAllMocks();
    });

    it('renders the dashboard correctly', async () => {
        const ristoratoreInfo = {
            id: ristoratoreId,
            nome: 'Test Ristoratore',
            indirizzo: 'Test Address',
            telefono: '123456789',
            capienza: 50,
            orario: '9:00 - 18:00',
        };
        const prenotazioni = [
            {
                id: 1,
                orario: new Date().toISOString(),
                nome: 'Test Client',
                numero_inviti: 1,
                stato: 'In attesa',
            },
        ];

        axiosClient.get.mockImplementation((url) => {
            if (url.includes(`/get-ristoratore/${ristoratoreId}`)) {
                return Promise.resolve({ data: ristoratoreInfo });
            }
            if (url.includes(`/prenotazioni/${ristoratoreId}`)) {
                return Promise.resolve({ data: prenotazioni });
            }
            return Promise.reject(new Error('not found'));
        });

        renderWithContext(<RistoratoreDashboard />);

        expect(screen.getByText('Caricamento informazioni...')).toBeInTheDocument();

        await waitFor(() => {
            expect(screen.getByText(/Nome: Test Ristoratore/i)).toBeInTheDocument();
            expect(screen.getByText(/Indirizzo: Test Address/i)).toBeInTheDocument();
            expect(screen.getByText(/Telefono: 123456789/i)).toBeInTheDocument();
            expect(screen.getByText(/Capienza: 50/i)).toBeInTheDocument();
            expect(screen.getByText(/Orario: 9:00 - 18:00/i)).toBeInTheDocument();
            expect(screen.getByText('Test Client')).toBeInTheDocument();
            expect(screen.getByText('1')).toBeInTheDocument(); // Number of invitations
            expect(screen.getByText('In attesa')).toBeInTheDocument();
        });
    });

    it('handles API errors', async () => {
        axiosClient.get.mockRejectedValue(new Error('API Error'));

        renderWithContext(<RistoratoreDashboard />);

        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('error');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Errore durante il recupero delle informazioni del ristoratore.');
        });
    });

    it('updates prenotazione status', async () => {
        const ristoratoreInfo = {
            id: ristoratoreId,
            nome: 'Test Ristoratore',
            indirizzo: 'Test Address',
            telefono: '123456789',
            capienza: 50,
            orario: '9:00 - 18:00',
        };
        const prenotazioni = [
            {
                id: 1,
                orario: new Date().toISOString(),
                nome: 'Test Client',
                numero_inviti: 1,
                stato: 'In attesa',
            },
        ];

        axiosClient.get.mockImplementation((url) => {
            if (url.includes(`/get-ristoratore/${ristoratoreId}`)) {
                return Promise.resolve({ data: ristoratoreInfo });
            }
            if (url.includes(`/prenotazioni/${ristoratoreId}`)) {
                return Promise.resolve({ data: prenotazioni });
            }
            return Promise.reject(new Error('not found'));
        });

        axiosClient.put.mockResolvedValue({ data: { status: 'success' } });

        renderWithContext(<RistoratoreDashboard />);

        await waitFor(() => {
            expect(screen.getByText('Test Client')).toBeInTheDocument();
        });

        const acceptButton = screen.getByText('Accetta');
        fireEvent.click(acceptButton);

        await waitFor(() => {
            expect(axiosClient.put).toHaveBeenCalledWith(`/update-prenotazioni/1`, { stato: 'Accettata' });
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Prenotazione accettata con successo.');
        });
    });

    it('handles empty prenotazioni list', async () => {
        const ristoratoreInfo = {
            id: ristoratoreId,
            nome: 'Test Ristoratore',
            indirizzo: 'Test Address',
            telefono: '123456789',
            capienza: 50,
            orario: '9:00 - 18:00',
        };

        axiosClient.get.mockImplementation((url) => {
            if (url.includes(`/get-ristoratore/${ristoratoreId}`)) {
                return Promise.resolve({ data: ristoratoreInfo });
            }
            if (url.includes(`/prenotazioni/${ristoratoreId}`)) {
                return Promise.resolve({ data: [] });
            }
            return Promise.reject(new Error('not found'));
        });

        renderWithContext(<RistoratoreDashboard />);

        await waitFor(() => {
            expect(screen.getByText(/Nome: Test Ristoratore/i)).toBeInTheDocument();
            expect(screen.getByText('Nessuna prenotazione disponibile.')).toBeInTheDocument();
        });
    });
});
