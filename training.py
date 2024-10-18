# Required libraries
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import joblib

# Load dataset
df = pd.read_csv('customer_churn_data.csv')

# Preprocess dataset (adapt according to your dataset)
df['Intl_Plan'] = df['Intl_Plan'].map({'yes': 1, 'no': 0})
df['VMail_Plan'] = df['VMail_Plan'].map({'yes': 1, 'no': 0})
df['Churn'] = df['Churn'].map({'yes': 1, 'no': 0})

# Drop unnecessary columns (such as 'State')
X = df.drop(columns=['Churn', 'State'])

# The target variable
y = df['Churn']

# Train-test split
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Feature scaling
scaler = StandardScaler()
X_train = scaler.fit_transform(X_train)
X_test = scaler.transform(X_test)

# Train model (using RandomForestClassifier for simplicity)
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# Evaluate the model
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
print(f"Model Accuracy: {accuracy * 100:.2f}%")
print(classification_report(y_test, y_pred))

# Save the model and scaler for later use in the Flask API
joblib.dump(model, 'churn_model.pkl')
joblib.dump(scaler, 'scaler.pkl')
