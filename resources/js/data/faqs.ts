export interface FaqItem {
  id: number
  question: string
  answer: string | string[]
}

export const faqs: FaqItem[] = [
  {
    id: 1,
    question: "1. ¿Qué es Mr Lana?",
    answer: "Es una entidad financiera de microcréditos que trabaja con compromiso y pasión por ofrecer préstamos rápidos a clientes con actividad comercial (negocios) y clientes sin actividad comercial (empleados), con el objetivo de impulsar el crecimiento y desarrollo de proyectos productivos en el país."
  },
  {
    id: 2,
    question: "2. ¿Qué documentos se solicitan para un cliente con actividad comercial (negocios)?",
    answer: [
      "Mr. Lana para otorgar un crédito solicitamos:",
      "Comprobante de domicilio no mayor a 3 meses de antigüedad.",
      "Identificación oficial vigente."
    ]
  },
  {
    id: 3,
    question: "3. ¿Qué documentos se solicitan para un cliente sin actividad comercial (empleados)?",
    answer: [
      "Mr. Lana para otorgar un crédito solicitamos:",
      "Comprobante de domicilio no mayor a 3 meses de antigüedad.",
      "Identificación oficial vigente.",
      "Comprobante de ingresos."
    ]
  },
  {
    id: 4,
    question: "4. ¿En qué tiempo se otorga un crédito?",
    answer: "Actualmente contamos con un tiempo de otorgamiento de crédito promedio de 20 minutos, es decir que en ese tiempo contarás con tu crédito."
  },
  {
    id: 5,
    question: "5. ¿Quién puede adquirir un crédito?",
    answer: [
      "Todo cliente que cumpla con los siguientes requisitos.",
      "Contar con un negocio establecido o un empleo.",
      "Mayor de edad."
    ]
  },
  {
    id: 6,
    question: "6. ¿Puedo adquirir un crédito si no cuento con un negocio establecido?",
    answer: "Si, Mr. Lana también otorga crédito a clientes que no cuenten con negocio, pero si con un empleo."
  },
  {
    id: 7,
    question: "7. ¿Cobran algún costo por apertura?",
    answer: "Para los clientes con actividad comercial (negocio) solo se realiza un cobro con descuento al crédito por la compra de un Seguro de Vida por la empresa aseguradora SAVE HEART SAS DE CV. Para los clientes sin actividad comercial (empleados) si se cobran una comisión por apertura del 5% del monto solicitado."
  },
  {
    id: 8,
    question: "8. ¿Cuál es el costo de la póliza de seguro?",
    answer: "El costo de la póliza corresponde a $100.00, descontados de cada desembolso de crédito."
  },
  {
    id: 9,
    question: "9. ¿En dónde puedo realizar mi pago?",
    answer: "En Mr. Lana buscamos impulsar tu negocio, por ende, nuestros gestores de crédito se encargan de hacer el cobro en tu negocio. En caso de ser un cliente sin actividad comercial (empleado), se asigna una cuenta bancaria de la empresa para que transfieras o deposites tus pagos."
  },
  {
    id: 10,
    question: "10. ¿Al realizar algún pago se entrega algún comprobante?",
    answer: "Si, en Mr. Lana al momento de recibir tu pago, el gestor de crédito entrega un ticket de pago, asimismo firma un control de pagos que se entrega al cliente para que lleve el registro de su crédito. De igual forma, puedes solicitar tu estado de cuenta con tu gestor de crédito o desde tu App Mobile."
  },
  {
    id: 11,
    question: "11. ¿Revisan buró de crédito?",
    answer: "No, en Mr. Lana confiamos en ti como cliente, por ende, no revisamos buró de crédito."
  },
  {
    id: 12,
    question: "12. ¿Solicitan aval?",
    answer: "No, en Mr. Lana confiamos en tu compromiso y responsabilidad por adquirir un crédito."
  },
  {
    id: 13,
    question: "13. ¿Como cliente que documentos firmaré para adquirir un crédito?",
    answer: [
      "Para adquirir un crédito en Mr. Lana únicamente se firma lo siguiente:",
      "Solicitud de crédito",
      "Contrato de crédito",
      "Pagaré",
      "Aviso de privacidad",
      "Seguro de vida"
    ]
  },
  {
    id: 14,
    question: "14. ¿Puedo renovar mi crédito?",
    answer: "Si, en Mr. Lana puedes renovar tu crédito las 'n' veces que desees, de acuerdo a las políticas de renovación podrás hacerlo anticipadamente."
  },
  {
    id: 15,
    question: "15. ¿Puedo contar con más de una línea de crédito?",
    answer: "Si, en Mr. Lana medimos tu capacidad de pago y por ello, cada cliente puede contar con dos líneas de crédito como máximo, si es que aplica."
  },
  {
    id: 16,
    question: "16. ¿Qué tipo de tasa de interés manejan?",
    answer: "En Mr. Lana, manejamos una tasa de interés tipo Flat es decir cada pago es constante."
  },
  {
    id: 17,
    question: "17. ¿Puedo liquidar mi crédito en cualquier momento?",
    answer: "Si, en Mr. Lana puedes realizar la liquidación de tu crédito anticipadamente."
  },
  {
    id: 18,
    question: "18. ¿Al liquidar mi crédito anticipadamente existe algún tipo de descuento?",
    answer: "No, en Mr. Lana manejamos una tasa Flat es decir, cada pago es constante, por ende, no existe ningún tipo de descuento."
  },
  {
    id: 19,
    question: "19. ¿Se requieren anticipos o depósitos para adquirir un crédito?",
    answer: "Si eres un cliente sin actividad comercial (empleado), se realiza un descuento en tu desembolso por concepto de comisión por apertura, en caso de ser un cliente con actividad comercial no se cobra ningún tipo de anticipo y/o depósito para solicitar y adquirir tu crédito."
  },
  {
    id: 20,
    question: "20. ¿Puedo dar pagos parciales?",
    answer: "No, en Mr. Lana manejamos una tasa flat por ende, los pagos siempre son constantes. Sólo se reciben pagos completos."
  },
  {
    id: 21,
    question: "21. ¿Qué pasa si el gestor de crédito no me entrega mi ticket de pago?",
    answer: "En Mr. Lana nos aseguramos que tu crédito sea una experiencia grata con la misión de impulsarte, por ello ante cada pago que sea entregado al gestor de crédito tiene la obligación y responsabilidad de entregarle su ticket con los datos de su crédito, en caso de que no sea así, consulte los teléfonos de las oficinas más cercanas para atender la situación."
  },
  {
    id: 22,
    question: "22. ¿Qué puedo hacer si mi gestor de crédito no ha pasado por mi pago?",
    answer: "En caso de presentar alguna eventualidad bajo la cual el gestor no haya pasado por su pago, es importante que se comunique a los teléfonos de la sucursal más cercana para poder revisar la situación y generar su pago. Estos teléfonos se encuentran en nuestra página Web o en su defecto en la parte inferior de su control de pagos."
  },
  {
    id: 23,
    question: "23. ¿Cuál es el monto de crédito inicial que puedo solicitar?",
    answer: "Los montos de crédito iniciales en modalidades de pago diario son de $3,000.00 o $4,000.00 o $5,000.00, en caso de modalidad de pago semanal son de $3,000.00, $4,000.00, $5,000.00 o $10,000.00."
  },
  {
    id: 24,
    question: "24. ¿Debo tener historial crediticio para solicitar un crédito Mr. Lana?",
    answer: "No, en Mr. Lana queremos que inicies tu historial crediticio con nosotros."
  },
  {
    id: 25,
    question: "25. ¿Por qué no me autorizaron un aumento?",
    answer: "En Mr. Lana contamos con políticas de crédito para ofrecerte un servicio de calidad, en caso de que se haya negado el aumento de tu crédito puede ser derivado por un exceso de retrasos en tus pagos o por la misma capacidad de pago que presente el negocio."
  },
  {
    id: 26,
    question: "26. ¿Cómo puedo saber si mi solicitud de crédito fue autorizada?",
    answer: "Al momento de realizar la solicitud nuestro equipo de mesa de control evalúa para indicar a nuestro gestor de crédito si fue rechazado o autorizado, en caso de ser autorizado nuestro gestor de crédito le explicará el siguiente paso para realizar su desembolso."
  },
  {
    id: 27,
    question: "27. ¿Cuáles son los pasos para adquirir un crédito Mr. Lana?",
    answer: [
      "En Mr. Lana somos prácticos en el otorgamiento de crédito, por esta razón el trámite es sencillo siguiendo estos pasos:",
      "Entrega a tu gestor de crédito tus documentos.",
      "Llena los formatos de crédito Mr. Lana.",
      "Grabamos un pequeño video de solicitud de crédito, donde se aprecia el negocio y/o vivienda del cliente, este es fundamental ya que es la parte medular para la autorización del crédito.",
      "Mesa de control evalúa el video de solicitud de crédito.",
      "Mesa de control autoriza y notifica al gestor de crédito.",
      "Gestor de crédito realiza y graba el video de desembolso de crédito.",
      "A disfrutar e invertir tu crédito."
    ]
  },
  {
    id: 28,
    question: "28. ¿Qué pasa si el gestor me grabó el video de desembolso, pero no me entregó mi desembolso?",
    answer: "En Mr. Lana somos una institución financiera transparente en sus procesos y en caso de alguna anomalía en su proceso de solicitud de crédito es importante comunicarse a los teléfonos de la sucursal más cercana para atender de inmediato la situación."
  },
  {
    id: 29,
    question: "29. ¿Puedo cambiar de plazo y producto?",
    answer: "Si, en Mr. Lana queremos que tengas el crédito a tu medida, por esta razón si es tu deseo podrás realizar el cambio de plazo o producto al momento de renovación de crédito, para ello es importante hacerle mención a su gestor de crédito."
  },
  {
    id: 30,
    question: "30. ¿En qué consiste mi seguro y cuáles son sus beneficios?",
    answer: "El seguro que ofrece Save Hearts respalda su crédito en caso de fallecimiento y al beneficiario que usted haya seleccionado, (este último debe ser mayor de edad), se le entregará $7,500.00 por concepto de gastos funerarios."
  },
  {
    id: 31,
    question: "31. ¿Puedo solicitar un préstamo por la app de clientes?",
    answer: 
      "No. La app de clientes sirve únicamente para monitorear el comportamiento de tus créditos actuales, así como el historial de créditos con nosotros. Es una herramienta de control y consulta para el cliente."
  }
]