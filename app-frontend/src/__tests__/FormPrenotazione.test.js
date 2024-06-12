import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import FormPrenotazione from '../views/FormPrenotazione';
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
                <MemoryRouter initialEntries={['/formprenotazione/123']}>
                    <Routes>
                        <Route path="/formprenotazione/:id" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('Testing reservation form', () => {
    const clientId = '12345';
    let mockUseStateContext;

    beforeEach(() => {

        mockUseStateContext = {
            profile: clientId,
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        localStorage.removeItem('RISTORATORE_ID');
        jest.clearAllMocks();
    });

    it('Form rendered correctly',async () => {
        axiosClient.post.mockResolvedValue({
            data : {
                prenotazione : 'prenotazione',
            }
        });
        renderWithContext(<FormPrenotazione/>);

        expect(screen.getByText('Data')).toBeInTheDocument();

        act(() => {
            fireEvent.change(screen.getByTestId('npersone'),{target:{value : 6}});
            fireEvent.change(screen.getByTestId('data'),{target:{value:'2024-07-22'}});
            fireEvent.click(screen.getByRole('button'));
        });
        expect(axiosClient.post).toHaveBeenCalledWith('/crea-prenotazione',
            {
                ristoratore: '123',
                orario:'2024-07-22' ,
                numero_inviti: '6',
            }
        );

        await waitFor( () => {
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Prenotazione creata con successo.');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
        }
        );
    })

    it('Reservation request goes wrong', async () => {
        axiosClient.post.mockRejectedValueOnce({
            data : {
            }
        });
        renderWithContext(<FormPrenotazione/>);

        act(() => {
            fireEvent.change(screen.getByTestId('npersone'),{target:{value : 6}});
            fireEvent.change(screen.getByTestId('data'),{target:{value:'2024-07-22'}});
            fireEvent.click(screen.getByRole('button'));
        });
        expect(axiosClient.post).toHaveBeenCalledWith('/crea-prenotazione',
            {
                ristoratore: '123',
                orario:'2024-07-22' ,
                numero_inviti: '6',
            }
        );

        await waitFor( () => {
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Errore durante il salvataggio della prenotazione.');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('error');
            expect(screen.getByText('Errore durante il salvataggio della prenotazione.'));
        }
        );
    });
});