export interface CreditSpecs {
    [key: string]: string;
}

export interface Credit {
    id: string;
    name: string;
    schedule: 'Semanal';
    payments: number;
    creditRange: string;
    icon: string;
    alt: string;
    modalId: string;
    specs: CreditSpecs;
}

export const credits: Credit[] = [
    {
        id: 's12',
        name: 's12',
        schedule: 'Semanal',
        payments: 12,
        creditRange: 'de $3,000 a $25,000',
        icon: '/img/icons/icon-credit-s12.png',
        alt: 's12',
        modalId: 'modal-i20',
        specs: {
            "Esquema": "Semanal",
            "Plazo": "12 pagos",
            "Monto Inicial": "$3,000.00, $4,000.00, $5,000.00",
            "Monto Mínimo": "$3,000.00",
            "Monto Máximo": "$25,000.00",
            "Póliza": "$100",
            "Multa": "$12.50 por cada $1000",
            "Aumento": "$1,000.00 cada ciclo, de acuerdo a política de aumentos",
            "Costos": "No Aplica",
            "CAT": "2696.26%"
        }
    },
    {
        id: 's16',
        name: 's16',
        schedule: 'Semanal',
        payments: 16,
        creditRange: 'de $5,000 a $25,000',
        icon: '/img/icons/icon-credit-s16.png',
        alt: 's16',
        modalId: 'modal-i20',
        specs: {
            "Esquema": "Semanal",
            "Plazo": "12 pagos",
            "Monto Inicial": "$5,000.00",
            "Monto Mínimo": "$5,000.00",
            "Monto Máximo": "$25,000.00",
            "Póliza": "$100",
            "Multa": "$12.50 por cada $1000",
            "Aumento": "$1,000.00 cada ciclo, de acuerdo a política de aumentos",
            "Costos": "No Aplica",
            "CAT": "2566.47%"
        }
    },
    {
        id: 's20',
        name: 's20',
        schedule: 'Semanal',
        payments: 20,
        creditRange: 'de $10,000 a $50,000',
        icon: '/img/icons/icon-credit-s20.png',
        alt: 's20',
        modalId: 'modal-i20',
        specs: {
            "Esquema": "Semanal",
            "Plazo": "12 pagos",
            "Monto Inicial": "$10,000.00",
            "Monto Mínimo": "$10,000.00",
            "Monto Máximo": "$50,000.00",
            "Póliza": "$100",
            "Multa": "$12.50 por cada $1000",
            "Aumento": "$1,000.00 por cada ciclo de acuerdo a política de aumentos",
            "Costos": "No Aplica",
            "CAT": "2015.39%"
        }
    },
    {
        id: 's24',
        name: 's24',
        schedule: 'Semanal',
        payments: 24,
        creditRange: 'de $10,000 a $50,000',
        icon: '/img/icons/icon-credit-s24.png',
        alt: 's24',
        modalId: 'modal-i20',
        specs: {
            "Esquema": "Semanal",
            "Plazo": "12 pagos",
            "Monto Inicial": "$10,000.00",
            "Monto Mínimo": "$10,000.00",
            "Monto Máximo": "$50,000.00",
            "Póliza": "$100",
            "Multa": "$12.50 por cada $1000",
            "Aumento": "$1,000.00 por cada ciclo de acuerdo a política de aumentos",
            "Costos": "No Aplica",
            "CAT": "1900.02%"
        }
    }
];