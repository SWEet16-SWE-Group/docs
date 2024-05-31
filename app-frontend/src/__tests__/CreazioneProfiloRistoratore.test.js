import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { ContextProvider } from '../contexts/ContextProvider';
import CreazioneProfiloRistoratore from '../views/CreazioneProfiloRistoratore';
import axiosClient from '../axios-client';

jest.mock('../axios-client');

const renderWithContext = (component) => {
    return render(
        <ContextProvider>
            {component}
        </ContextProvider>
    );
};

describe('CreazioneProfiloRistoratore', () => {
    it('renders the form correctly', () => {
        renderWithContext(<CreazioneProfiloRistoratore/>);
        expect(screen.getByText('Crea account ristoratore')).toBeInTheDocument();
        expect(screen.getByLabelText('Nome')).toBeInTheDocument();
        expect(screen.getByLabelText('Indirizzo')).toBeInTheDocument();
        expect(screen.getByLabelText('Telefono')).toBeInTheDocument();
        expect(screen.getByLabelText('Capienza')).toBeInTheDocument();
        expect(screen.getByLabelText('Orario apertura - chiusura')).toBeInTheDocument();
    });
});