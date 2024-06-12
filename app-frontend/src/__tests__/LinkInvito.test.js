import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import RistoratoreDashboard from '../views/DashboardRistoratore';
import axiosClient from '../axios-client';
import { act } from 'react';
import LinkInvito from '../views/LinkInvito';

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
                <MemoryRouter initialEntries={['/invito/123']}>
                    <Routes>
                        <Route path="/invito/:prenotazione" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('Testiamo il bellissimo Link di Invito!', () => {
    const client_ID = '12345';
    let mockUseStateContext;

    beforeEach(() => {
    
        mockUseStateContext = {
            profile: client_ID,
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    it('Initial render goes smoothly', async() => {
        axiosClient.get.mockResolvedValueOnce({
            data : {
                nome : 'Da Luigi',
                orario :'20:00',
                partecipanti : 5,
            }
        });
        renderWithContext(<LinkInvito/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_dettagli/123');
        expect(screen.getByText('Sei stato invitato a partecipare a quest\'uscita')).toBeInTheDocument();

        await waitFor (() => {
            expect(screen.getByText(/Da Luigi/i)).toBeInTheDocument();
            expect(screen.getByText(/20:00/i)).toBeInTheDocument();
            expect(screen.getByText(/5/i)).toBeInTheDocument();
        }) ;
    });

    it('Invitation acceptance goes smoothly', async() => {
        axiosClient.get.mockResolvedValueOnce({
            data : {
                nome : 'Da Luigi',
                orario :'20:00',
                partecipanti : 5,
            }
        });
        renderWithContext(<LinkInvito/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_dettagli/123');

        await waitFor (() => {
            expect(screen.getByText(/Da Luigi/i)).toBeInTheDocument();
            expect(screen.getByText(/20:00/i)).toBeInTheDocument();
            expect(screen.getByText(/5/i)).toBeInTheDocument();
        }) ;
        
        axiosClient.post.mockResolvedValueOnce(
            {
                data : '',
            }
        );
        act( () => {
            const buttons=screen.getAllByRole('button');
            fireEvent.click(buttons[0]);
        }) ;
        expect(axiosClient.post).toHaveBeenCalledWith('/crea-invito/',{
            prenotazione : '123',
            cliente : client_ID,
        });
        
    });

    it('Invitation acceptance goes wrong!', async() => {
        axiosClient.get.mockResolvedValueOnce({
            data : {
                nome : 'Da Luigi',
                orario :'20:00',
                partecipanti : 5,
            }
        });
        renderWithContext(<LinkInvito/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_dettagli/123');
        expect(screen.getByText('Sei stato invitato a partecipare a quest\'uscita')).toBeInTheDocument();

        await waitFor (() => {
            expect(screen.getByText(/Da Luigi/i)).toBeInTheDocument();
            expect(screen.getByText(/20:00/i)).toBeInTheDocument();
            expect(screen.getByText(/5/i)).toBeInTheDocument();
        }) ;

        axiosClient.post.mockRejectedValueOnce({
            data : '',
        });

        act( () => {
            const buttons=screen.getAllByRole('button');
            fireEvent.click(buttons[0]);
        }) ;
        expect(axiosClient.post).toHaveBeenCalledWith('/crea-invito/',{
            prenotazione : '123',
            cliente : client_ID,
        });

        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('error');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Errore durante l\'invito alla prenotazione.');
        });
    });

    it('Simply ignoring the invitation...', async() => {
        axiosClient.get.mockResolvedValueOnce({
            data : {
                nome : 'Da Luigi',
                orario :'20:00',
                partecipanti : 5,
            }
        });
        renderWithContext(<LinkInvito/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_dettagli/123');
        expect(screen.getByText('Sei stato invitato a partecipare a quest\'uscita')).toBeInTheDocument();

        await waitFor (() => {
            expect(screen.getByText(/Da Luigi/i)).toBeInTheDocument();
            expect(screen.getByText(/20:00/i)).toBeInTheDocument();
            expect(screen.getByText(/5/i)).toBeInTheDocument();
        }) ;

        act( () => {
            const buttons=screen.getAllByRole('button');
            fireEvent.click(buttons[1]);
        }) ;

    });
});