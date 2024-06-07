import React from 'react';
import axiosClient from '../axios-client';
import { ContextProvider } from '../contexts/ContextProvider';
import ModificaProfiloCliente from '../views/ModificaProfiloCliente';
import '@testing-library/jest-dom/extend-expect';
import { waitFor } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';

jest.mock('../axios-client');

const renderWithContext = (component) => {
    return render(
      <ContextProvider>
        <MemoryRouter>
            {component}
        </MemoryRouter>
      </ContextProvider>
    );
};

describe('ModificaProfiloCliente', () => {

    beforeEach( () => {
        axiosClient.get.mockResolvedValueOnce({
            data : {
                nome : 'Tullio'
            }
        }
        );
    });

    it('Form correctly rendered',async () => {

        renderWithContext(<ModificaProfiloCliente/>);

        await waitFor(() => {
            expect(screen.getByText('Modifica le informazioni relative a questo profilo')).toBeInTheDocument();
            expect(screen.getByLabelText('Username')).toBeInTheDocument();
            expect(screen.getByText(/Tullio/i)).toBeInTheDocument();
            expect(screen.getByText('Conferma modifiche')).toBeInTheDocument();
            expect(screen.getByText('Annulla')).toBeInTheDocument();
        });

        it('Changed username rendered correctly',async () => {
            renderWithContext(<ModificaProfiloCliente/>);

            await waitFor ( () => {
                expect(screen.getByText(/Tullio/i)).toBeInTheDocument();
            });

            act(() => {
                fireEvent.change(screen.getByLabelText('Username'), { target: { value: 'Tullio 2:la vendetta' } });
            });

            expect(screen.getByText(/Tullio 2:la vendetta/i)).toBeInTheDocument();
        });
    });
});
