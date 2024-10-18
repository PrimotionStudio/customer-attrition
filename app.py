from flask import Flask, request, jsonify
import joblib
import numpy as np

app = Flask(__name__)

# Load the saved model and scaler
model = joblib.load('churn_model.pkl')
scaler = joblib.load('scaler.pkl')


@app.route('/predict', methods=['POST'])
def predict_churn():
    # Get JSON data from the request
    data = request.json

    # Extract features from the data (ensure order is correct)
    features = [
        data['account_length'], data['area_code'], data['intl_plan'], data['vmail_plan'],
        data['vmail_messages'], data['day_minutes'], data['day_calls'], data['day_charge'],
        data['eve_minutes'], data['eve_calls'], data['eve_charge'],
        data['night_minutes'], data['night_calls'], data['night_charge'],
        data['intl_minutes'], data['intl_calls'], data['intl_charge'],
        data['service_calls']
    ]

    # Scale the features
    features = np.array(features).reshape(1, -1)
    scaled_features = scaler.transform(features)

    # Predict churn
    prediction = model.predict(scaled_features)
    churn_result = 'CHURN' if prediction[0] == 1 else 'NO CHURN'

    return jsonify({'prediction': churn_result})


if __name__ == '__main__':
    app.run(debug=True)
